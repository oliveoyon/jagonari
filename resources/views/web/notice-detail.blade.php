@extends('layouts.web')

@section('title', $notice->title)

@section('content')

<!-- Page Title -->
<div class="page-title dark-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">{{ $notice->title }}</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">হোম</a></li>
                <li><a href="{{ route('notice.board') }}">নোটিশ বোর্ড</a></li>
                <li class="current">{{ $notice->title }}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->

<section class="section notice-detail">
    <div class="container">

        <!-- Attachment -->
        @if($notice->attachment)
            @if($notice->attachment_type === 'image')
                <img src="{{ asset('storage/'.$notice->attachment) }}" class="img-fluid mb-3" alt="{{ $notice->title }}">
            @elseif($notice->attachment_type === 'pdf')
                <div class="mb-3">
                    <embed src="{{ asset('storage/'.$notice->attachment) }}" type="application/pdf" width="100%" height="600px">
                </div>
            @endif
        @endif

        <!-- Description -->
        @if($notice->description)
            <div class="notice-description mb-3">
                {!! nl2br(e($notice->description)) !!}
            </div>
        @endif

        <!-- Published Date -->
        @if($notice->published_at)
            <small class="text-muted">প্রকাশিত: {{ $notice->published_at->format('d M, Y') }}</small>
        @endif

    </div>
</section>

@endsection

@push('styles')
<style>
.notice-detail img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}
.notice-detail embed {
    border: 1px solid #ccc;
    border-radius: 5px;
}
.notice-description {
    font-size: 1rem;
    line-height: 1.6;
}
</style>
@endpush
