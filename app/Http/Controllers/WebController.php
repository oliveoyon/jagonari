<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\HomeSlider;
use App\Models\JobApplication;
use App\Models\JobCircular;
use App\Models\Menu;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function home()
    {
        $sliders = HomeSlider::where('is_active', 1)->get();
        $teamMembers = TeamMember::where('is_active', 1)->get();
        return view('home', compact('sliders', 'teamMembers'));
    }

    public function showPage($slug)
    {
        $menu = Menu::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        return view('dynamic-page', compact('menu'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Your message has been sent successfully.');
    }

    public function jobList()
    {
        // Paginate 10 jobs per page
        $jobs = JobCircular::where('status', true)
            ->orderBy('published_date', 'desc')
            ->paginate(10);

        return view('web.jobs.index', compact('jobs'));
    }
    // Show single job detail
    public function jobDetail($slug)
    {
        $job = JobCircular::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('web.jobs.detail', compact('job'));
    }

    // Store job application
    public function applyJob(Request $request, $slug)
    {
        $job = JobCircular::where('slug', $slug)->where('status', true)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'resume' => 'required|file|mimes:pdf,doc,docx',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');
        $coverPath = $request->file('cover_letter') ? $request->file('cover_letter')->store('cover_letters', 'public') : null;

        JobApplication::create([
            'job_circular_id' => $job->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'resume' => $resumePath,
            'cover_letter' => $coverPath,
            'status' => 'applied',
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted successfully.');
    }
}
