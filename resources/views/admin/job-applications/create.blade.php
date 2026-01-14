@extends('admin.layouts.app')

@section('title', 'নতুন জব আবেদন')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">নতুন জব আবেদন</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.job-applications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row mb-3">
            <div class="col-md-6">
                <label>সার্কুলার</label>
                <select name="job_circular_id" class="form-control" required>
                    <option value="">-- সার্কুলার নির্বাচন করুন --</option>
                    @foreach($circulars as $circular)
                        <option value="{{ $circular->id }}">{{ $circular->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>প্রার্থী নাম</label>
                <input type="text" name="name" class="form-control" required>
            </div>
        </div>

        <div class="form-row mb-3">
            <div class="col-md-6">
                <label>ইমেইল</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="col-md-6">
                <label>ফোন</label>
                <input type="text" name="phone" class="form-control">
            </div>
        </div>

        <div class="form-group mb-3">
            <label>রেজিউমে (PDF/DOC/DOCX)</label>
            <input type="file" name="resume" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>কভার লেটার (PDF/DOC/DOCX)</label>
            <input type="file" name="cover_letter" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label>স্ট্যাটাস</label>
            <select name="status" class="form-control">
                <option value="applied">Applied</option>
                <option value="shortlisted">Shortlisted</option>
                <option value="rejected">Rejected</option>
                <option value="selected">Selected</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">সংরক্ষণ করুন</button>
        <a href="{{ route('admin.job-applications.index') }}" class="btn btn-secondary">ব্যাক</a>
    </form>
</div>
@endsection
