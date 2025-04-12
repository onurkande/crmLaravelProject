<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::latest()->paginate(12);
        return view('admin.notes.index', compact('notes'));
    }

    public function create()
    {
        return view('admin.notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('notes/images', 'public');
            $data['image_path'] = $imagePath;
        }

        Note::create($data);

        return redirect()->route('admin.notes.index')->with('success', 'Not başarıyla oluşturuldu.');
    }

    public function show(Note $note)
    {
        return view('admin.notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('admin.notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Eski resmi sil
            if ($note->image_path) {
                Storage::disk('public')->delete($note->image_path);
            }
            
            $imagePath = $request->file('image')->store('notes/images', 'public');
            $data['image_path'] = $imagePath;
        }

        $note->update($data);

        return back()->with('success', 'Not başarıyla güncellendi.');
    }

    public function destroy(Note $note)
    {
        if ($note->image_path) {
            Storage::disk('public')->delete($note->image_path);
        }
        
        $note->delete();

        return redirect()->route('admin.notes.index')->with('deleted', 'Not başarıyla silindi.');
    }
} 