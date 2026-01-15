@extends('layouts.web')

@section('title', 'Jagonari Pragati Songstha')

@section('content')
    <section id="hero" class="hero section dark-background">

        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            @foreach ($sliders as $key => $slider)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}">
                    <div class="container">
                        <h2>{{ $slider->title }}</h2>
                        <p>{{ $slider->short_description }}</p>
                        <a href="#" class="btn-get-started">Get Started</a>
                    </div>
                </div>
            @endforeach

            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

            <ol class="carousel-indicators"></ol>

        </div>

    </section>
    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section light-background">

        <div class="container">

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-12 text-center">
                    <h3>আমাদের সাথে যুক্ত হন</h3>
                    <p>
                        আপনার প্রয়োজনীয় তথ্য, সেবা এবং সহায়তা পেতে আমাদের প্ল্যাটফর্মের সাথে যুক্ত থাকুন।
                        আমরা সর্বদা স্বচ্ছতা, দক্ষতা এবং বিশ্বাসযোগ্য সেবা প্রদানে প্রতিশ্রুতিবদ্ধ।
                        আধুনিক প্রযুক্তি ও অভিজ্ঞ টিমের মাধ্যমে আমরা আপনাকে সর্বোচ্চ মানের সহায়তা দিতে কাজ করছি।
                    </p>

                    <a class="cta-btn mt-3 d-inline-block" href="#">
                        এখনই শুরু করুন
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- /Call To Action Section -->
    <!-- Team Section -->
    <section id="team" class="team section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Team</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">
            <div class="row gy-4">

                @foreach ($teamMembers as $index => $member)
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="{{ ($index + 1) * 100 }}">

                        <div class="team-member">

                            <div class="member-img">
                                <img src="{{ $member->image ? Storage::url($member->image) : asset('assets/img/team/default.jpg') }}"
                                    class="img-fluid" alt="{{ $member->name }}">

                                {{-- Social Icons (static, as schema has no social fields) --}}
                                <div class="social">
                                    @if ($member->email)
                                        <a href="mailto:{{ $member->email }}">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                    @endif

                                    @if ($member->phone)
                                        <a href="tel:{{ $member->phone }}">
                                            <i class="bi bi-telephone"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="member-info">
                                <h4>{{ $member->name }}</h4>
                                <span>
                                    {{ $member->email ?? 'Team Member' }}
                                </span>
                            </div>

                        </div>
                    </div><!-- End Team Member -->
                @endforeach

            </div>
        </div>

    </section><!-- /Team Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>ডিজিটাল সেবা</h3>
                        </a>
                        <p>
                            আধুনিক প্রযুক্তির মাধ্যমে দ্রুত, সহজ এবং নির্ভরযোগ্য ডিজিটাল সেবা প্রদান করা হয়
                            যাতে ব্যবহারকারীরা সহজেই প্রয়োজনীয় তথ্য ও সহায়তা পেতে পারেন।
                        </p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>তথ্য প্রচার</h3>
                        </a>
                        <p>
                            গুরুত্বপূর্ণ ঘোষণা, নোটিশ এবং হালনাগাদ তথ্য দ্রুত ও কার্যকরভাবে
                            ব্যবহারকারীদের কাছে পৌঁছে দেওয়ার জন্য এই সেবাটি প্রদান করা হয়।
                        </p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-easel"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>প্রশিক্ষণ ও কর্মশালা</h3>
                        </a>
                        <p>
                            দক্ষতা উন্নয়ন ও সচেতনতা বৃদ্ধির লক্ষ্যে নিয়মিত প্রশিক্ষণ এবং
                            কর্মশালার আয়োজন করা হয়, যা অংশগ্রহণকারীদের জ্ঞান বৃদ্ধি করে।
                        </p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-bounding-box-circles"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>ব্যবস্থাপনা সহায়তা</h3>
                        </a>
                        <p>
                            বিভিন্ন কার্যক্রম পরিকল্পনা, সমন্বয় এবং বাস্তবায়নে
                            প্রয়োজনীয় ব্যবস্থাপনা সহায়তা প্রদান করা হয়।
                        </p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-calendar4-week"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>ইভেন্ট ও সময়সূচি</h3>
                        </a>
                        <p>
                            বিভিন্ন ইভেন্ট, কার্যক্রম এবং সময়সূচি সম্পর্কে সঠিক ও
                            হালনাগাদ তথ্য প্রদান করে ব্যবহারকারীদের সচেতন রাখা হয়।
                        </p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-chat-square-text"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>পরামর্শ ও সহায়তা</h3>
                        </a>
                        <p>
                            ব্যবহারকারীদের প্রশ্ন, সমস্যা এবং মতামতের ভিত্তিতে
                            প্রয়োজনীয় পরামর্শ ও দিকনির্দেশনা প্রদান করা হয়।
                        </p>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>

    </section>
    <!-- /Services Section -->





@endsection
