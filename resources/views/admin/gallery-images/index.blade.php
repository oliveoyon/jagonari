@extends('admin.layouts.app')

@section('title','গ্যালারি ইমেজ ম্যানেজমেন্ট')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">গ্যালারি ইমেজ ম্যানেজমেন্ট</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter by Event --}}
    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <select name="event_id" class="form-control" onchange="this.form.submit()">
                    <option value="">সব ইভেন্ট</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ (isset($eventId) && $eventId == $event->id) ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <a href="{{ route('admin.gallery-images.create') }}" class="btn btn-primary mb-3">নতুন ছবি যোগ করুন</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ইভেন্ট</th>
                <th>শিরোনাম</th>
                <th>ছবি</th>
                <th>ডিসপ্লে অর্ডার</th>
                <th>সক্রিয়</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach($images as $img)
            <tr>
                <td>{{ $img->event->title }}</td>
                <td>{{ $img->title ?? '-' }}</td>
                <td>
                    <img src="{{ asset('storage/'.$img->image) }}" width="80">
                </td>
                <td>{{ $img->display_order }}</td>
                <td>{{ $img->is_active ? 'হ্যাঁ' : 'না' }}</td>
                <td>
                    <a href="{{ route('admin.gallery-images.edit', $img->id) }}" class="btn btn-sm btn-primary">এডিট</a>
                    <form action="{{ route('admin.gallery-images.destroy', $img->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">মুছুন</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
