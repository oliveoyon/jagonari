<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    // List all
    public function index()
    {
        $teamMembers = TeamMember::latest()->get();
        return view('admin.team_members.index', compact('teamMembers'));
    }

    // Store new
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);


        // Handle image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->back()->with('success', 'টিম মেম্বার সফলভাবে যোগ হয়েছে।');
    }

    // Update existing
    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);


        if ($request->hasFile('image')) {
            if ($teamMember->image) {
                Storage::disk('public')->delete($teamMember->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $teamMember->update($data);

        return redirect()->back()->with('success', 'টিম মেম্বার সফলভাবে আপডেট হয়েছে।');
    }

    // Delete
    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->image) {
            Storage::disk('public')->delete($teamMember->image);
        }
        $teamMember->delete();

        return redirect()->back()->with('success', 'টিম মেম্বার সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
