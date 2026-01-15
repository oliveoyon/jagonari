<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    // List all contact messages
    public function index(Request $request)
    {
        $query = ContactMessage::query()->orderBy('created_at', 'desc');

        // Filter by read status
        if ($request->has('filter')) {
            if ($request->filter == 'pending') {
                $query->where('is_read', 0);
            } elseif ($request->filter == 'read') {
                $query->where('is_read', 1);
            }
        }

        $messages = $query->get();

        return view('admin.contact-messages.index', compact('messages'));
    }


    // View single message
    public function show(ContactMessage $contactMessage)
    {
        // Mark as read if not already
        if ($contactMessage->is_read == 0) {
            $contactMessage->update(['is_read' => 1]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    // Delete message
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
