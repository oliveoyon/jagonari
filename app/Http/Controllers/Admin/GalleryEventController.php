<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryEvent;
use Illuminate\Support\Str;

class GalleryEventController extends Controller
{
    // Show all events
    public function index()
    {
        $events = GalleryEvent::orderBy('display_order')->get();
        return view('admin.gallery-events.index', compact('events'));
    }

    // Store new event
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ]);

        GalleryEvent::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => $request->has('is_active'), // ✅ FIX
        ]);

        return redirect()
            ->route('admin.gallery-events.index')
            ->with('success', 'ইভেন্ট সফলভাবে যোগ করা হয়েছে');
    }

    // Update event
    public function update(Request $request, GalleryEvent $galleryEvent)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ]);

        $galleryEvent->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'description' => $validated['description'] ?? null,
            'display_order' => $validated['display_order'] ?? 0,
            'is_active' => $request->has('is_active'), // ✅ FIX
        ]);

        return redirect()
            ->route('admin.gallery-events.index')
            ->with('success', 'ইভেন্ট সফলভাবে আপডেট করা হয়েছে');
    }

    // Delete event
    public function destroy(GalleryEvent $galleryEvent)
    {
        $galleryEvent->delete();

        return redirect()
            ->route('admin.gallery-events.index')
            ->with('success', 'ইভেন্ট সফলভাবে মুছে ফেলা হয়েছে');
    }
}
