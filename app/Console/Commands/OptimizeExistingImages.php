<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Models\AdvertisementImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OptimizeExistingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize existing images and create thumbnails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image optimization...');

        // İlan kapak resimlerini optimize et
        $advertisements = Advertisement::all();
        $this->processAdvertisements($advertisements);

        // İlan galeri resimlerini optimize et
        $galleryImages = AdvertisementImage::all();
        $this->processGalleryImages($galleryImages);

        $this->info('Image optimization completed!');
    }

    private function processAdvertisements($advertisements)
    {
        $bar = $this->output->createProgressBar(count($advertisements));
        $bar->start();

        foreach ($advertisements as $advertisement) {
            if ($advertisement->cover_image && Storage::disk('public')->exists($advertisement->cover_image)) {
                try {
                    $imagePath = $advertisement->cover_image;
                    $image = Storage::disk('public')->get($imagePath);
                    
                    // Yeni optimize edilmiş resimleri oluştur
                    $imageInstance = Image::make($image);
                    
                    // Büyük resim (1920x1080)
                    $largeImage = Image::make($image)
                        ->resize(1920, 1080, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode('webp', 85);
                    
                    // Thumbnail (600x400)
                    $thumbImage = Image::make($image)
                        ->resize(600, 400, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->sharpen(10)
                        ->encode('webp', 90);
                    
                    // Yeni resimleri kaydet
                    $largeImagePath = str_replace('.webp', '_large.webp', $imagePath);
                    $thumbImagePath = str_replace('.webp', '_thumb.webp', $imagePath);
                    
                    Storage::disk('public')->put($largeImagePath, (string) $largeImage);
                    Storage::disk('public')->put($thumbImagePath, (string) $thumbImage);
                    
                    // Veritabanını güncelle
                    $advertisement->cover_image = $largeImagePath;
                    $advertisement->save();
                    
                    // Orijinal resmi sil
                    Storage::disk('public')->delete($imagePath);
                    
                } catch (\Exception $e) {
                    $this->error("Error processing advertisement {$advertisement->id}: " . $e->getMessage());
                }
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    private function processGalleryImages($galleryImages)
    {
        $bar = $this->output->createProgressBar(count($galleryImages));
        $bar->start();

        foreach ($galleryImages as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                try {
                    $imagePath = $image->image_path;
                    $imageContent = Storage::disk('public')->get($imagePath);
                    
                    // Sadece büyük versiyon oluştur (1920x1080)
                    $largeImage = Image::make($imageContent)
                        ->resize(1920, 1080, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode('webp', 85);
                    
                    // Yeni resmi kaydet (sonuna _large veya _thumb eklemeden)
                    Storage::disk('public')->put($imagePath, (string) $largeImage);
                    
                } catch (\Exception $e) {
                    $this->error("Error processing gallery image {$image->id}: " . $e->getMessage());
                }
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }
}
