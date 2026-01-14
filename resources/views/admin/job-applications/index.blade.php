@extends('admin.layouts.app')

@section('title', 'জব আবেদনসমূহ')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">জব আবেদনসমূহ</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.job-applications.create') }}" class="btn btn-success">নতুন আবেদন</a>
        </div>

        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="job_circular_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- সার্কুলার ফিল্টার করুন --</option>
                        @foreach ($circulars as $circular)
                            <option value="{{ $circular->id }}"
                                {{ request('job_circular_id') == $circular->id ? 'selected' : '' }}>
                                {{ $circular->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>সিরিয়াল</th>
                    <th>প্রার্থী নাম</th>
                    <th>ইমেইল</th>
                    <th>ফোন</th>
                    <th>সার্কুলার</th>
                    <th>রেজিউমে</th>
                    <th>কভার লেটার</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $index => $app)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $app->name }}</td>
                        <td>{{ $app->email }}</td>
                        <td>{{ $app->phone }}</td>
                        <td>{{ $app->circular->title }}</td>
                        <td>
                            @if ($app->resume)
                                <a href="{{ asset('storage/' . $app->resume) }}" target="_blank">ডাউনলোড</a>
                            @endif
                        </td>
                        <td>
                            @if ($app->cover_letter)
                                <a href="{{ asset('storage/' . $app->cover_letter) }}" target="_blank">ডাউনলোড</a>
                            @endif
                        </td>
                        <td>{{ ucfirst($app->status) }}</td>
                        <td>
                            <a href="{{ route('admin.job-applications.edit', $app->id) }}"
                                class="btn btn-sm btn-primary">এডিট</a>
                            <form action="{{ route('admin.job-applications.destroy', $app->id) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('আপনি কি নিশ্চিত?')">মুছুন</button>
                            </form>
                            @if ($app->status == 'selected')
                                <a href="{{ route('admin.job-applications.admit-card', $app->id) }}"
                                    class="btn btn-sm btn-success" target="_blank">
                                    অ্যাডমিট কার্ড
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
