@extends('admin.layouts.app')

@section('title', 'গ্যালারি ইমেজ যোগ করুন')

@section('content')

    <style>
        .form-label {
            font-weight: 500;
        }

        .form-control-sm {
            height: 38px;
            /* uniform height */
        }
    </style>
    <div class="container-fluid">
        <h1 class="mb-4">গ্যালারি ইমেজ যোগ করুন</h1>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-primary shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.gallery-images.bulk-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        {{-- Event Selection --}}
                        <div class="col-md-3">
                            <label for="event_id" class="form-label">ইভেন্ট <span class="text-danger">*</span></label>
                            <select name="event_id" id="event_id" class="form-select form-control-sm" required>
                                <option value="">-- ইভেন্ট নির্বাচন করুন --</option>
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Title Input --}}
                        <div class="col-md-3">
                            <label for="title" class="form-label">শিরোনাম</label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm"
                                placeholder="শিরোনাম">
                        </div>

                        {{-- Description Input --}}
                        <div class="col-md-3">
                            <label for="description" class="form-label">বর্ণনা</label>
                            <input type="text" name="description" id="description" class="form-control form-control-sm"
                                placeholder="বর্ণনা">
                        </div>

                        {{-- Active Checkbox --}}
                        <div class="col-md-1 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-success w-100" type="submit">
                                <i class="fas fa-plus-circle me-1"></i> যোগ করুন
                            </button>
                        </div>

                        {{-- File Upload --}}
                        <div class="col-12 mt-3">
                            <label for="images" class="form-label">ছবি আপলোড করুন <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple required>
                            <small class="text-muted">একাধিক ছবি নির্বাচন করতে Ctrl বা Shift চেপে ধরুন</small>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
