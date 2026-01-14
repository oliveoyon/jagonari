<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    // Helper for Bangla slug
    private function bangla_slug($string) {
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $string);
        $slug = trim($slug, '-');
        return $slug;
    }

    // Index: List menus
    public function index()
    {
        $menus = Menu::with('parent')->orderBy('display_order')->get();
        return view('admin.menus.index', compact('menus'));
    }

    // Store: Create new menu
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:menus,slug',
            'parent_id' => 'nullable|exists:menus,id',
            'content' => 'nullable|string',
            'main_image' => 'nullable|image|max:2048',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Bangla slug
        $data['slug'] = $request->slug ? $request->slug : $this->bangla_slug($request->title);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('menus', 'public');
        }

        Menu::create($data);

        return response()->json(['message' => 'মেনু সফলভাবে তৈরি হয়েছে।']);
    }

    // Show: Get menu for edit
    public function show(Menu $menu)
    {
        return response()->json($menu);
    }

    // Update menu
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:menus,slug,'.$menu->id,
            'parent_id' => 'nullable|exists:menus,id',
            'content' => 'nullable|string',
            'main_image' => 'nullable|image|max:2048',
            'display_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['slug'] = $request->slug ? $request->slug : $this->bangla_slug($request->title);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('main_image')) {
            // delete old image
            if($menu->main_image) {
                Storage::disk('public')->delete($menu->main_image);
            }
            $data['main_image'] = $request->file('main_image')->store('menus', 'public');
        }

        $menu->update($data);

        return response()->json(['message' => 'মেনু সফলভাবে আপডেট হয়েছে।']);
    }

    // Delete menu
    public function destroy(Menu $menu)
    {
        if($menu->main_image) {
            Storage::disk('public')->delete($menu->main_image);
        }
        $menu->delete();
        return response()->json(['message' => 'মেনু সফলভাবে মুছে ফেলা হয়েছে।']);
    }

    // Upload image for Summernote
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'ছবি আপলোড করতে ব্যর্থ হয়েছে।'], 422);
        }

        $path = $request->file('file')->store('menu-content', 'public');

        return response()->json(['url' => '/storage/'.$path]);
    }
}
