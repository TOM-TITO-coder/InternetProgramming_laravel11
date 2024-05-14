<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Add this line
use Intervention\Image\ImageManagerStatic as ImageManager; // Add this line

class GalleryController extends Controller
{
    public function gallery()
    {
        $images = Image::all();
        return view('gallery', compact('images'));
    }

    public function add()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png',
            'name' => 'nullable|string',
            'type' => 'nullable|string'
        ]);

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
            'title' => 'required|string|max:255',
        ]);

        $image = $request->file('image');
        $imageName = $validatedData['title'] . '.' . $image->getClientOriginalExtension();

        // Store image in MinIO
        $path = Storage::disk('minio')->put('image/img/gallery/' . $imageName , file_get_contents($image));

        // Save image details of image to database
        $newImage = Image::create([
            'image' => $imageName, 
        ]);

        return redirect('/gallery');
    }
}
