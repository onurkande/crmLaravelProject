<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementImage;
use App\Models\AdvertisementFeature;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    // Resim yükleme yardımcı fonksiyonu
    private function saveImageAsWebp($image, $path)
    {
        $filename = time() . '_' . uniqid();
        
        // Eğer kapak resmi ise (covers klasöründe)
        if (strpos($path, 'covers') !== false) {
            // Büyük Görseli Optimize Et (1920x1080)
            $largeImage = Image::make($image->getRealPath())
                ->resize(1920, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 85);
        
            $largeImagePath = $path . $filename . '_large.webp';
            Storage::disk('public')->put($largeImagePath, (string) $largeImage);
        
            // Thumbnail (600x400)
            $thumbImage = Image::make($image->getRealPath())
                ->resize(600, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->sharpen(10)
                ->encode('webp', 90);
        
            $thumbImagePath = $path . $filename . '_thumb.webp';
            Storage::disk('public')->put($thumbImagePath, (string) $thumbImage);
        
            return [
                'large' => $largeImagePath,
                'thumbnail' => $thumbImagePath
            ];
        } 
        // Eğer galeri resmi ise (gallery klasöründe)
        else {
            // Sadece büyük versiyon oluştur (1920x1080)
            $largeImage = Image::make($image->getRealPath())
                ->resize(1920, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 85);
        
            $imagePath = $path . $filename . '.webp';
            Storage::disk('public')->put($imagePath, (string) $largeImage);
        
            return [
                'large' => $imagePath,
                'thumbnail' => $imagePath
            ];
        }
    }

    public function index(Request $request)
    {
        $query = Advertisement::query();

        // Satış durumu filtresi
        if ($request->filled('sale_status')) {
            $query->where('sale_status', $request->sale_status);
        }

        // Rezerve durumu filtresi
        if ($request->filled('reserve_status')) {
            $query->where('reserve_status', $request->reserve_status);
        }

        // Depozito durumu filtresi
        if ($request->filled('deposit_status')) {
            $query->where('deposit_status', $request->deposit_status);
        }

        // Oda tipi filtresi
        if ($request->filled('room_types')) {
            $roomTypes = explode(',', $request->room_types);
            $query->whereIn('room_type', $roomTypes);
        }

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Fiyat aralığı filtresi
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Fiyat sıralama filtresi
        if ($request->filled('price_sort')) {
            if ($request->price_sort === 'asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->price_sort === 'desc') {
                $query->orderBy('price', 'desc');
            }
        } else {
            $query->latest();
        }

        $advertisements = $query->paginate(9)->appends(request()->query());

        return view('admin.advertisement.index', compact('advertisements'));
    }
    

    public function create()
    {
        return view('admin.advertisement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'deposit_status' => 'nullable|in:Ödendi,Ödenmedi',
            'sale_status' => 'nullable|in:Satıldı,Satılmadı',
            'reserve_status' => 'nullable|in:Rezerve Edildi,Rezerve Edilmedi',
            'cover_image' => 'required|image',
            'images.*' => 'image',
            'debt_amount' => 'nullable|numeric',
            'square_meters' => 'required|numeric',
            'apartment_number' => 'required',
            'room_type' => 'required',
            'map_location' => 'nullable',
            'city' => 'nullable|string',
            'commission' => 'nullable|integer|min:0',
        ]);

        // Kapak fotoğrafını webp olarak kaydet
        if ($request->hasFile('cover_image')) {
            $imagePaths = $this->saveImageAsWebp($request->file('cover_image'), 'advertisements/covers/');
            $coverImagePath = $imagePaths['large'];
        }

        // İlanı oluştur
        $advertisement = Advertisement::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'deposit_status' => $request->deposit_status,
            'sale_status' => $request->sale_status,
            'reserve_status' => $request->reserve_status,
            'cover_image' => $coverImagePath,
            'debt_amount' => $request->debt_amount,
            'square_meters' => $request->square_meters,
            'apartment_number' => $request->apartment_number,
            'room_type' => $request->room_type,
            'city' => $request->city,
            'map_location' => $request->map_location,
            'created_by' => Auth::id(),
            'commission' => $request->commission,
        ]);

        // Diğer resimleri webp olarak kaydet
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths = $this->saveImageAsWebp($image, 'advertisements/gallery/');
                AdvertisementImage::create([
                    'advertisement_id' => $advertisement->id,
                    'image_path' => $imagePaths['large']
                ]);
            }
        }

        // Özellikleri kaydet
        AdvertisementFeature::create([
            'advertisement_id' => $advertisement->id,
            'supermarket' => $request->has('supermarket'),
            'spa_sauna_massage' => $request->has('spa_sauna_massage'),
            'exchange_office' => $request->has('exchange_office'),
            'cafe_bar' => $request->has('cafe_bar'),
            'gift_shop' => $request->has('gift_shop'),
            'pharmacy' => $request->has('pharmacy'),
            'bank' => $request->has('bank'),
            'bicycle_path' => $request->has('bicycle_path'),
            'green_areas' => $request->has('green_areas'),
            'restaurant' => $request->has('restaurant'),
            'playground' => $request->has('playground'),
            'water_slides' => $request->has('water_slides'),
            'walking_track' => $request->has('walking_track'),
            'fitness_gym' => $request->has('fitness_gym'),
            'football_field' => $request->has('football_field'),
            'pool' => $request->has('pool'),
            'security' => $request->has('security'),
            'parking' => $request->has('parking'),
            'ev_charging' => $request->has('ev_charging')
        ]);

        return redirect()->route('admin.advertisements.index')->with('success', 'İlan başarıyla oluşturuldu.');
    }

    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisement.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'deposit_status' => 'nullable|in:Ödendi,Ödenmedi',
            'sale_status' => 'nullable|in:Satıldı,Satılmadı',
            'reserve_status' => 'nullable|in:Rezerve Edildi,Rezerve Edilmedi',
            'cover_image' => 'nullable|image',
            'images.*' => 'nullable|image',
            'debt_amount' => 'nullable|numeric',
            'square_meters' => 'required|numeric',
            'apartment_number' => 'required',
            'room_type' => 'required',
            'map_location' => 'nullable',
            'city' => 'nullable|string',
            'commission' => 'nullable|integer|min:0',
        ]);

        // Kapak fotoğrafını webp olarak güncelle
        if ($request->hasFile('cover_image')) {
            // Eski resimleri sil
            Storage::disk('public')->delete($advertisement->cover_image);
            Storage::disk('public')->delete($advertisement->cover_image_thumb);
            
            // Yeni resimleri kaydet
            $imagePaths = $this->saveImageAsWebp($request->file('cover_image'), 'advertisements/covers/');
            $advertisement->cover_image = $imagePaths['large'];
        }

        $advertisement->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'deposit_status' => $request->deposit_status,
            'sale_status' => $request->sale_status,
            'reserve_status' => $request->reserve_status,
            'debt_amount' => $request->debt_amount,
            'square_meters' => $request->square_meters,
            'apartment_number' => $request->apartment_number,
            'room_type' => $request->room_type,
            'city' => $request->city,
            'map_location' => $request->map_location,
            'commission' => $request->commission,
        ]);

        // Silinecek resimleri sil
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = AdvertisementImage::find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    Storage::disk('public')->delete(str_replace('_large.webp', '_thumb.webp', $image->image_path));
                    $image->delete();
                }
            }
        }

        // Yeni resimleri webp olarak ekle
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths = $this->saveImageAsWebp($image, 'advertisements/gallery/');
                AdvertisementImage::create([
                    'advertisement_id' => $advertisement->id,
                    'image_path' => $imagePaths['large']
                ]);
            }
        }

        // Özellikleri güncelle
        $advertisement->features()->update([
            'supermarket' => $request->has('supermarket'),
            'spa_sauna_massage' => $request->has('spa_sauna_massage'),
            'exchange_office' => $request->has('exchange_office'),
            'cafe_bar' => $request->has('cafe_bar'),
            'gift_shop' => $request->has('gift_shop'),
            'pharmacy' => $request->has('pharmacy'),
            'bank' => $request->has('bank'),
            'bicycle_path' => $request->has('bicycle_path'),
            'green_areas' => $request->has('green_areas'),
            'restaurant' => $request->has('restaurant'),
            'playground' => $request->has('playground'),
            'water_slides' => $request->has('water_slides'),
            'walking_track' => $request->has('walking_track'),
            'fitness_gym' => $request->has('fitness_gym'),
            'football_field' => $request->has('football_field'),
            'pool' => $request->has('pool'),
            'security' => $request->has('security'),
            'parking' => $request->has('parking'),
            'ev_charging' => $request->has('ev_charging')
        ]);

        return back()->with('success', 'İlan başarıyla güncellendi.');
    }

    public function destroy(Advertisement $advertisement)
    {
        // Resimleri sil
        if ($advertisement->cover_image) {
            // Kapak resminin large ve thumb versiyonlarını sil
            Storage::disk('public')->delete($advertisement->cover_image);
            Storage::disk('public')->delete(str_replace('_large.webp', '_thumb.webp', $advertisement->cover_image));
        }
        
        // Galeri resimlerini sil
        foreach ($advertisement->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $advertisement->delete();

        return redirect()->route('admin.advertisements.index')->with('deleted', 'İlan başarıyla silindi.');
    }

    public function show(Advertisement $advertisement)
    {
        return view('admin.advertisement.show', compact('advertisement'));
    }

    public function generatePDF(Advertisement $advertisement)
    {
        $settings = SiteSetting::first();
    
        // Dinamik olarak logo dosya yolunu al
        $logoPath = "/home/noyanlar/public_html/storage/" . $settings->logo;
    
        // Dosyanın gerçekten var olup olmadığını kontrol et
        if (file_exists($logoPath)) {
            $image = base64_encode(file_get_contents($logoPath));
            $imageSrc = "data:image/png;base64," . $image;
        } else {
            $imageSrc = null; // Eğer dosya yoksa null gönder
        }
    
        // Dinamik olarak ilan resmi dosya yolunu al
        $advertisementImagePath = "/home/noyanlar/public_html/storage/" . $advertisement->cover_image;
    
        // Dosyanın gerçekten var olup olmadığını kontrol et
        if (file_exists($advertisementImagePath)) {
            $advertisementImage = base64_encode(file_get_contents($advertisementImagePath));
            $advertisementImageSrc = "data:image/png;base64," . $advertisementImage;
        } else {
            $advertisementImageSrc = null; // Eğer dosya yoksa null gönder
        }
    
        // PDF oluştur ve indir
        $pdf = PDF::loadView('admin.advertisement.pdf', compact('advertisement', 'imageSrc', 'advertisementImageSrc', 'settings'));
        return $pdf->download('ilan-' . $advertisement->id . '.pdf');
    }
} 