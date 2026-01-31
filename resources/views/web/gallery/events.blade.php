@extends('layouts.web')

@section('title', 'গ্যালারি')

@push('styles')
<style>
    .gallery-section {
        background: #f5f7fa;
    }

    .gallery-event-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 30px 20px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }

    .gallery-event-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 28px rgba(0,0,0,0.12);
    }

    .gallery-event-card h4 {
        font-weight: 600;
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">গ্যালারি</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">হোম</a></li>
                    <li class="current">গ্যালারি</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Gallery Events Section -->
    <section class="section gallery-section">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">

                @forelse($events as $event)
                    <div class="col-lg-4 col-md-6">
                        <div class="gallery-event-card text-center">
                            <h4>{{ $event->title }}</h4>

                            @if($event->description)
                                <p class="mt-2">{{ $event->description }}</p>
                            @endif

                            <a href="{{ route('gallery.event.images', $event->slug) }}"
                               class="btn btn-primary mt-3">
                                ছবি দেখুন
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>কোনো গ্যালারি ইভেন্ট পাওয়া যায়নি।</p>
                    </div>
                @endforelse

            </div>

        </div>
    </section>
    <!-- End Gallery Events Section -->

@endsection
