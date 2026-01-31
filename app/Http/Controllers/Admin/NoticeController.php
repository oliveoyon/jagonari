<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    // List notices
    public function index()
    {
        $notices = Notice::latest()->get();
        return view('admin.notices.index', compact('notices'));
    }

    // Show single notice (AJAX edit)
    public function show(Notice $notice)
    {
        return response()->json($notice);
    }

    // Store notice
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $data['attachment'] = $file->store('notices', 'public');
            $data['attachment_type'] = $file->getClientOriginalExtension() === 'pdf'
                ? 'pdf'
                : 'image';
        }

        Notice::create($data);

        return response()->json(['message' => 'নোটিশ সফলভাবে যোগ করা হয়েছে।']);
    }

    // Update notice
    public function update(Request $request, Notice $notice)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'is_active'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('attachment')) {
            if ($notice->attachment) {
                Storage::disk('public')->delete($notice->attachment);
            }

            $file = $request->file('attachment');
            $data['attachment'] = $file->store('notices', 'public');
            $data['attachment_type'] = $file->getClientOriginalExtension() === 'pdf'
                ? 'pdf'
                : 'image';
        }

        $data['is_active'] = $request->boolean('is_active');

        $notice->update($data);

        return response()->json(['message' => 'নোটিশ সফলভাবে আপডেট হয়েছে।']);
    }

    // Delete notice
    public function destroy(Notice $notice)
    {
        if ($notice->attachment) {
            Storage::disk('public')->delete($notice->attachment);
        }

        $notice->delete();

        return response()->json(['message' => 'নোটিশ সফলভাবে মুছে ফেলা হয়েছে।']);
    }
}
