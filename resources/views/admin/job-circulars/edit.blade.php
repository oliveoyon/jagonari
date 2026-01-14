@extends('admin.layouts.app')

@section('title', 'জব সার্কুলার এডিট')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">জব সার্কুলার এডিট</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.job-circulars.update', $jobCircular->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label>শিরোনাম</label>
                    <input type="text" name="title" class="form-control" value="{{ $jobCircular->title }}" required>
                </div>
                <div class="col-md-6">
                    <label>ডিপার্টমেন্ট</label>
                    <input type="text" name="department" class="form-control" value="{{ $jobCircular->department }}">
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label>আবেদন শেষ তারিখ</label>
                    <input type="date" name="application_deadline" class="form-control"
                        value="{{ $jobCircular->application_deadline }}">
                </div>
                <div class="col-md-6">
                    <label>প্রকাশের তারিখ</label>
                    <input type="date" name="published_date" class="form-control"
                        value="{{ $jobCircular->published_date }}">
                </div>
            </div>

            <div class="form-group mb-3">
                <label>বিবরণ</label>
                <textarea name="description" class="form-control summernote" rows="4">{{ $jobCircular->description }}</textarea>
            </div>


            <div class="form-group mb-3">
                <label>ফাইল (PDF/ছবি)</label>
                <input type="file" name="file" class="form-control">
                @if ($jobCircular->file)
                    <a href="{{ asset('storage/' . $jobCircular->file) }}" target="_blank">বর্তমান ফাইল দেখুন</a>
                @endif
            </div>

            <div class="form-group mb-3">
                <label>খালি / সক্রিয়</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $jobCircular->status ? 'selected' : '' }}>সক্রিয়</option>
                    <option value="0" {{ !$jobCircular->status ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                </select>
            </div>

            <div class="form-row mb-3">
                <div class="col-md-6">
                    <label>ভ্যাকেন্সি সংখ্যা</label>
                    <input type="number" name="vacancy_count" class="form-control"
                        value="{{ $jobCircular->vacancy_count }}">
                </div>
            </div>

            <button type="submit" class="btn btn-success">আপডেট করুন</button>
            <a href="{{ route('admin.job-circulars.index') }}" class="btn btn-secondary">ব্যাক</a>
        </form>
    </div>
@endsection

@push('scripts')
<!-- Summernote CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            callbacks: {
                onImageUpload: function(files) {
                    // TODO: handle image upload if you want to save images via ajax
                }
            }
        });
    });
</script>
@endpush

