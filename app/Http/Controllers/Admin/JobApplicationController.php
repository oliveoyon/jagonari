<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobCircular;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    // List all applications
    public function index(Request $request)
    {
        $circulars = JobCircular::where('status',1)->get();
        $applications = JobApplication::with('circular')->orderBy('created_at','desc');

        // Filter by circular
        if($request->filled('job_circular_id')){
            $applications->where('job_circular_id', $request->job_circular_id);
        }

        $applications = $applications->get();

        return view('admin.job-applications.index', compact('applications','circulars'));
    }

    // Show create form
    public function create()
    {
        $circulars = JobCircular::where('status',1)->get();
        return view('admin.job-applications.create', compact('circulars'));
    }

    // Store new application
    public function store(Request $request)
    {
        $request->validate([
            'job_circular_id' => 'required|exists:job_circulars,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:applied,shortlisted,rejected,selected'
        ]);

        $resumePath = $request->file('resume') ? $request->file('resume')->store('resumes','public') : null;
        $coverPath = $request->file('cover_letter') ? $request->file('cover_letter')->store('cover_letters','public') : null;

        JobApplication::create([
            'job_circular_id' => $request->job_circular_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'resume' => $resumePath,
            'cover_letter' => $coverPath,
            'status' => $request->status
        ]);

        return redirect()->route('admin.job-applications.index')->with('success','আবেদন সফলভাবে সংরক্ষিত হয়েছে');
    }

    // Show edit form
    public function edit(JobApplication $jobApplication)
    {
        $circulars = JobCircular::where('status',1)->get();
        return view('admin.job-applications.edit', compact('jobApplication','circulars'));
    }

    // Update application
    public function update(Request $request, JobApplication $jobApplication)
    {
        $request->validate([
            'job_circular_id' => 'required|exists:job_circulars,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx',
            'status' => 'required|in:applied,shortlisted,rejected,selected'
        ]);

        $data = $request->only(['job_circular_id','name','email','phone','status']);

        // Handle resume upload
        if($request->hasFile('resume')){
            if($jobApplication->resume && Storage::disk('public')->exists($jobApplication->resume)){
                Storage::disk('public')->delete($jobApplication->resume);
            }
            $data['resume'] = $request->file('resume')->store('resumes','public');
        }

        // Handle cover letter upload
        if($request->hasFile('cover_letter')){
            if($jobApplication->cover_letter && Storage::disk('public')->exists($jobApplication->cover_letter)){
                Storage::disk('public')->delete($jobApplication->cover_letter);
            }
            $data['cover_letter'] = $request->file('cover_letter')->store('cover_letters','public');
        }

        $jobApplication->update($data);

        return redirect()->route('admin.job-applications.index')->with('success','আবেদন সফলভাবে আপডেট হয়েছে');
    }

    // Delete application
    public function destroy(JobApplication $jobApplication)
    {
        // Delete files if exist
        if($jobApplication->resume && Storage::disk('public')->exists($jobApplication->resume)){
            Storage::disk('public')->delete($jobApplication->resume);
        }
        if($jobApplication->cover_letter && Storage::disk('public')->exists($jobApplication->cover_letter)){
            Storage::disk('public')->delete($jobApplication->cover_letter);
        }

        $jobApplication->delete();

        return redirect()->route('admin.job-applications.index')->with('success','আবেদন মুছে ফেলা হয়েছে');
    }
}
