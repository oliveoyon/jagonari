@extends('admin.layouts.app')

@section('title', 'জব আবেদন এডিট')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">জব আবেদন এডিট</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.job-applications.update', $jobApplication->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row mb-3">
            <div class="col-md-6">
                <label>সার্কুলার</label>
                <select name="job_circular_id" class="form-control" required>
                    <option value="">-- সার্কুলার নির্বাচন করুন --</option>
                    @foreach($circulars as $circular)
                        <option value="{{ $circular->id }}" {{ $jobApplication->job_circular_id == $circular->id ? 'selected' : '' }}>
                            {{ $circular->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>প্রার্থী নাম</label>
                <input type="text" name="name" class="form-control" value="{{ $jobApplication->name }}" required>
            </div>
        </div>

        <div class="form-row mb-3">
            <div class="col-md-6">
                <label>ইমেইল</label>
                <input type="email" name="email" class="form-control" value="{{ $jobApplication->email }}">
            </div>
            <div class="col-md-6">
                <label>ফোন</label>
                <input type="text" name="phone" class="form-control" value="{{ $jobApplication->phone }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label>রেজিউমে (PDF/DOC/DOCX)</label>
            <input type="file" name="resume" class="form-control mb-2">
            @if($jobApplication->resume)
                <a href="{{ asset('storage/'.$jobApplication->resume) }}" target="_blank">ডাউনলোড</a>
            @endif
        </div>

        <div class="form-group mb-3">
            <label>কভার লেটার (PDF/DOC/DOCX)</label>
            <input type="file" name="cover_letter" class="form-control mb-2">
            @if($jobApplication->cover_letter)
                <a href="{{ asset('storage/'.$jobApplication->cover_letter) }}" target="_blank">ডাউনলোড</a>
            @endif
        </div>

        <div class="form-group mb-3">
            <label>স্ট্যাটাস</label>
            <select name="status" class="form-control">
                <option value="applied" {{ $jobApplication->status=='applied' ? 'selected' : '' }}>Applied</option>
                <option value="shortlisted" {{ $jobApplication->status=='shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                <option value="rejected" {{ $jobApplication->status=='rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="selected" {{ $jobApplication->status=='selected' ? 'selected' : '' }}>Selected</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">আপডেট করুন</button>
        <a href="{{ route('admin.job-applications.index') }}" class="btn btn-secondary">ব্যাক</a>
    </form>
</div>
@endsection
