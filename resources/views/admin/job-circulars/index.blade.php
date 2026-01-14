@extends('admin.layouts.app')

@section('title', 'জব সার্কুলার ম্যানেজমেন্ট')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">জব সার্কুলার ম্যানেজমেন্ট</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.job-circulars.create') }}" class="btn btn-success mb-3">নতুন সার্কুলার যোগ করুন</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>শিরোনাম</th>
                <th>বিভাগ</th>
                <th>মোট পদ</th>
                <th>আবেদন শেষ তারিখ</th>
                <th>প্রকাশের তারিখ</th>
                <th>স্ট্যাটাস</th>
                <th>ফাইল</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach($circulars as $circular)
            <tr>
                <td>{{ $circular->title }}</td>
                <td>{{ $circular->department }}</td>
                <td>{{ $circular->vacancy_count }}</td>
                <td>{{ $circular->application_deadline }}</td>
                <td>{{ $circular->published_date }}</td>
                <td>{{ $circular->status ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</td>
                <td>
                    @if($circular->file)
                        <a href="{{ asset('storage/'.$circular->file) }}" target="_blank">ডাউনলোড / দেখুন</a>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.job-circulars.edit', $circular->id) }}" class="btn btn-sm btn-primary">এডিট</a>
                    <form action="{{ route('admin.job-circulars.destroy', $circular->id) }}" method="POST" style="display:inline-block">
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
