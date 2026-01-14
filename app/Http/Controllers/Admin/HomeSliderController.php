<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSliderController extends Controller
{
    // List all sliders
    public function index()
    {
        $sliders = HomeSlider::orderBy('display_order')->get();
        return view('admin.home-sliders.index', compact('sliders'));
    }

    // Show single slider (for AJAX edit modal)
    public function show(HomeSlider $homeSlider)
    {
        return response()->json($homeSlider);
    }

    // Store new slider
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'image' => 'required|image|max:2048',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Ensure is_active is boolean
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('home-sliders', 'public');
        }

        HomeSlider::create($data);

        return response()->json(['message' => 'স্লাইডার সফলভাবে তৈরি হয়েছে।']);
    }


    // Update slider
    public function update(Request $request, HomeSlider $homeSlider)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($homeSlider->image) {
                Storage::disk('public')->delete($homeSlider->image);
            }
            $data['image'] = $request->file('image')->store('home-sliders', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $homeSlider->update($data);

        return response()->json(['message' => 'স্লাইডার সফলভাবে আপডেট হয়েছে।']);
    }

    // Delete slider
    public function destroy(HomeSlider $homeSlider)
    {
        if ($homeSlider->image) {
            Storage::disk('public')->delete($homeSlider->image);
        }

        $homeSlider->delete();

        return response()->json(['message' => 'স্লাইডার সফলভাবে মুছে ফেলা হয়েছে।']);
    }
}
