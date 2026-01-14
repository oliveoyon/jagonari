@extends('admin.layouts.app')

@section('title','গ্যালারি ইমেজ এডিট করুন')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">গ্যালারি ইমেজ এডিট করুন</h1>

    <form action="{{ route('admin.gallery-images.update', $galleryImage->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-3">
                <select name="event_id" class="form-control" required>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ $galleryImage->event_id == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" name="title" value="{{ $galleryImage->title }}" class="form-control" placeholder="শিরোনাম">
            </div>
            <div class="col-md-3">
                <input type="number" name="display_order" value="{{ $galleryImage->display_order }}" class="form-control" placeholder="ডিসপ্লে অর্ডার">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $galleryImage->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">সক্রিয়</label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="file" name="image" class="form-control">
                @if($galleryImage->image)
                    <img src="{{ asset('storage/'.$galleryImage->image) }}" width="100" class="mt-2">
                @endif
            </div>
            <div class="col-md-6">
                <textarea name="description" class="form-control" placeholder="বর্ণনা">{{ $galleryImage->description }}</textarea>
            </div>
        </div>
        <button class="btn btn-success" type="submit">আপডেট করুন</button>
    </form>
</div>
@endsection
