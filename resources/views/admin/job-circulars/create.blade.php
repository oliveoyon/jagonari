@extends('admin.layouts.app')

@section('title', 'নতুন জব সার্কুলার')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">নতুন জব সার্কুলার যোগ করুন</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.job-circulars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label>শিরোনাম</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>বিভাগ</label>
                <input type="text" name="department" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label>মোট পদ</label>
                <input type="number" name="vacancy_count" class="form-control">
            </div>
            <div class="col-md-3">
                <label>আবেদন শেষ তারিখ</label>
                <input type="date" name="application_deadline" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>প্রকাশের তারিখ</label>
                <input type="date" name="published_date" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="status" class="form-check-input" value="1" checked>
                    <label class="form-check-label">সক্রিয়</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label>বর্ণনা (বা সার্কুলার ফাইল)</label>
                <textarea name="description" class="form-control summernote" rows="5"></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>ফাইল আপলোড (PDF, Image)</label>
                <input type="file" name="file" class="form-control">
            </div>
        </div>

        <button class="btn btn-success" type="submit">সংরক্ষণ করুন</button>
    </form>
</div>
@endsection

@push('scripts')
<!-- Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<script>
$(document).ready(function() {
    $('.summernote').summernote({
        height: 200
    });
});
</script>
@endpush
