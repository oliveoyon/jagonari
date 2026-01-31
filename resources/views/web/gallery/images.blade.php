@extends('layouts.web')

@section('title', $event->title)

@push('styles')
<style>
    .gallery-section {
        background: #f5f7fa;
    }

    .gallery-img-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform .3s ease;
    }

    .gallery-img-card:hover {
        transform: scale(1.03);
    }

    .gallery-img-card img {
        border-radius: 8px;
    }

    .modal-content {
        background: transparent;
        border: none;
    }
</style>
@endpush

@section('content')

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $event->title }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">হোম</a></li>
                    <li><a href="{{ route('gallery.events') }}">গ্যালারি</a></li>
                    <li class="current">{{ $event->title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Gallery Images Section -->
    <section class="section gallery-section">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">

                @forelse($images as $image)
                    <div class="col-lg-3 col-md-4 col-sm-6">

                        <div class="gallery-img-card"
                             data-bs-toggle="modal"
                             data-bs-target="#imageModal{{ $image->id }}">
                            <img src="{{ asset('storage/'.$image->image) }}"
                                 class="img-fluid"
                                 alt="{{ $image->title }}">
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="imageModal{{ $image->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/'.$image->image) }}"
                                             class="img-fluid rounded shadow">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>এই ইভেন্টে কোনো ছবি পাওয়া যায়নি।</p>
                    </div>
                @endforelse

            </div>

            <div class="text-center mt-4">
                <a href="{{ route('gallery.events') }}" class="btn btn-secondary">
                    ← গ্যালারিতে ফিরে যান
                </a>
            </div>

        </div>
    </section>
    <!-- End Gallery Images Section -->

@endsection
