@extends('layouts.web')

@section('title', 'নোটিশ বোর্ড')

@section('content')

<!-- Page Title -->
<div class="page-title dark-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">নোটিশ বোর্ড</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">হোম</a></li>
                <li class="current">নোটিশ বোর্ড</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->

<section class="section notice-board">
    <div class="container">
        @if($notices->isEmpty())
            <p>কোনো নোটিশ পাওয়া যায়নি।</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ক্রমিক</th>
                            <th>শিরোনাম</th>
                            <th>সংক্ষিপ্ত বিবরণ</th>
                            <th>সংযুক্তি</th>
                            <th>প্রকাশের তারিখ</th>
                            <th>একশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notices as $index => $notice)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $notice->title }}</td>
                            <td>{{ Str::limit($notice->description, 50, '...') }}</td>
                            <td>
                                @if($notice->attachment)
                                    @if($notice->attachment_type === 'image')
                                        <img src="{{ asset('storage/'.$notice->attachment) }}" alt="{{ $notice->title }}" style="height:50px; border-radius:5px;">
                                    @else
                                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $notice->published_at ? $notice->published_at->format('d M, Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('notice.detail', $notice->id) }}" class="btn btn-sm btn-primary">
                                    বিস্তারিত দেখুন
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
.notice-board table {
    background: #fff;
}
.notice-board th, .notice-board td {
    vertical-align: middle;
    text-align: center;
}
.notice-board img {
    max-height: 50px;
    object-fit: cover;
}
.notice-board a.btn-sm {
    font-size: 0.8rem;
}
</style>
@endpush
