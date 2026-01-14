<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobCircular;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class JobCircularController extends Controller
{
    // List all circulars
    public function index()
    {
        $circulars = JobCircular::orderBy('created_at','desc')->get();
        return view('admin.job-circulars.index', compact('circulars'));
    }

    // Show create form
    public function create()
    {
        return view('admin.job-circulars.create');
    }

    // Store new circular
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'application_deadline' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $filePath = null;
        $fileType = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileType = $file->getClientOriginalExtension();
            $filePath = $file->store('job_circulars', 'public');
        }

        JobCircular::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title), // English slug
            'description' => $request->description,
            'file' => $filePath,
            'file_type' => $fileType,
            'department' => $request->department,
            'vacancy_count' => $request->vacancy_count,
            'application_deadline' => $request->application_deadline,
            'published_date' => $request->published_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.job-circulars.index')->with('success', 'Job Circular added successfully');
    }

    // Show edit form
    public function edit(JobCircular $jobCircular)
    {
        return view('admin.job-circulars.edit', compact('jobCircular'));
    }

    // Update circular
    public function update(Request $request, JobCircular $jobCircular)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'application_deadline' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $data = $request->only([
            'title',
            'description',
            'department',
            'vacancy_count',
            'application_deadline',
            'published_date',
            'status',
        ]);

        $data['slug'] = Str::slug($request->title); // update slug

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($jobCircular->file && Storage::disk('public')->exists($jobCircular->file)) {
                Storage::disk('public')->delete($jobCircular->file);
            }
            $file = $request->file('file');
            $data['file'] = $file->store('job_circulars', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $jobCircular->update($data);

        return redirect()->route('admin.job-circulars.index')->with('success', 'Job Circular updated successfully');
    }

    // Delete circular
    public function destroy(JobCircular $jobCircular)
    {
        // Delete file if exists
        if ($jobCircular->file && Storage::disk('public')->exists($jobCircular->file)) {
            Storage::disk('public')->delete($jobCircular->file);
        }

        // TODO: Delete associated job applications if you want cascading delete
        // $jobCircular->applications()->delete();

        $jobCircular->delete();

        return redirect()->route('admin.job-circulars.index')->with('success', 'Job Circular deleted successfully');
    }
}
