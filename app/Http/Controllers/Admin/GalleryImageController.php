<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\GalleryEvent;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    // List all images with event filter
    public function index(Request $request)
    {
        $events = GalleryEvent::orderBy('display_order')->get();
        $eventId = $request->event_id;

        $images = GalleryImage::with('event')
            ->when($eventId, fn($q) => $q->where('event_id', $eventId))
            ->orderBy('display_order')
            ->get();

        return view('admin.gallery-images.index', compact('images','events','eventId'));
    }

    // Bulk upload form
    public function create()
    {
        $events = GalleryEvent::orderBy('display_order')->get();
        return view('admin.gallery-images.create', compact('events'));
    }

    // Bulk store images
    public function bulkStore(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:gallery_events,id',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        foreach ($request->file('images') as $file) {
            $path = $file->store('gallery_images', 'public');

            GalleryImage::create([
                'event_id' => $request->event_id,
                'image' => $path,
                'display_order' => 0,
                'is_active' => 1,
            ]);
        }

        return redirect()->route('admin.gallery-images.index')->with('success','ছবিগুলি সফলভাবে যোগ করা হয়েছে');
    }

    // Edit single image
    public function edit(GalleryImage $galleryImage)
    {
        $events = GalleryEvent::orderBy('display_order')->get();
        return view('admin.gallery-images.edit', compact('galleryImage','events'));
    }

    // Update single image
    public function update(Request $request, GalleryImage $galleryImage)
    {
        $request->validate([
            'event_id' => 'required|exists:gallery_events,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['event_id','title','description','display_order']);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($galleryImage->image && Storage::disk('public')->exists($galleryImage->image)) {
                Storage::disk('public')->delete($galleryImage->image);
            }
            $data['image'] = $request->file('image')->store('gallery_images','public');
        }

        $galleryImage->update($data);

        return redirect()->route('admin.gallery-images.index')->with('success','ছবি সফলভাবে আপডেট হয়েছে');
    }

    // Delete image
    public function destroy(GalleryImage $galleryImage)
    {
        if ($galleryImage->image && Storage::disk('public')->exists($galleryImage->image)) {
            Storage::disk('public')->delete($galleryImage->image);
        }
        $galleryImage->delete();

        return redirect()->route('admin.gallery-images.index')->with('success','ছবি সফলভাবে মুছে ফেলা হয়েছে');
    }
}
