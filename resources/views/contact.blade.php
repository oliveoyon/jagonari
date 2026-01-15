@extends('layouts.web')

@section('title', 'Contact')

@section('content')

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Contact</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="current">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Google Map -->
        @if (general_setting('google_map_url'))
            <div class="mb-5">
                <iframe style="width:100%; height:400px;" src="{{ general_setting('google_map_url') }}" frameborder="0"
                    allowfullscreen>
                </iframe>
            </div>
        @endif

        <div class="container" data-aos="fade">
            <div class="row gy-5 gx-lg-5">

                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="info">
                        <h3>Get in touch</h3>
                        <p>Please reach us using the information below or send a message.</p>

                        @if (general_setting('address'))
                            <div class="info-item d-flex">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h4>Address:</h4>
                                    <p>{{ general_setting('address') }}</p>
                                </div>
                            </div>
                        @endif

                        @if (general_setting('email1'))
                            <div class="info-item d-flex">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h4>Email:</h4>
                                    <p>{{ general_setting('email1') }}</p>
                                    @if (general_setting('email2'))
                                        <p>{{ general_setting('email2') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (general_setting('phone1'))
                            <div class="info-item d-flex">
                                <i class="bi bi-phone flex-shrink-0"></i>
                                <div>
                                    <h4>Call:</h4>
                                    <p>{{ general_setting('phone1') }}</p>
                                    @if (general_setting('phone2'))
                                        <p>{{ general_setting('phone2') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- End Contact Info -->

                <!-- Contact Form -->
                <div class="col-lg-8">

                    {{-- Success --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="php-email-form">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" placeholder="Your Name"
                                    value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" name="email" class="form-control" placeholder="Your Email"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <input type="text" name="subject" class="form-control" placeholder="Subject"
                                value="{{ old('subject') }}" required>
                        </div>

                        <div class="form-group mt-3">
                            <textarea name="message" rows="6" class="form-control" placeholder="Message" required>{{ old('message') }}</textarea>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
                <!-- End Contact Form -->

            </div>
        </div>
    </section>

@endsection
