@extends('layouts.web')

@section('title', $menu->title)

@section('content')

    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">{{ $menu->title }}</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    @if ($menu->parent)
                        <li><a href="{{ url($menu->parent->slug) }}">{{ $menu->parent->title }}</a></li>
                    @endif
                    <li class="current">{{ $menu->title }}</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <div class="container">

                        <article class="article">

                            <!-- Post Image -->
                            @if ($menu->main_image)
                                <div class="post-img">
                                    <img src="{{ Storage::url($menu->main_image) }}" alt="{{ $menu->title }}"
                                        class="img-fluid">
                                </div>
                            @endif

                            <!-- Post Title -->
                            <h2 class="title">{{ $menu->title }}</h2>

                            <!-- Meta Top (Optional: author/date/comments) -->
                            <div class="meta-top">
                                <ul>
                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a
                                            href="#"><time
                                                datetime="{{ $menu->created_at }}">{{ $menu->created_at->format('M d, Y') }}</time></a>
                                    </li>
                                </ul>
                            </div><!-- End meta top -->

                            <!-- Post Content -->
                            <div class="content">
                                {!! $menu->content !!}
                            </div><!-- End post content -->

                            <!-- Meta Bottom (Optional: categories/tags) -->
                            <div class="meta-bottom">
                                @if ($menu->category)
                                    <i class="bi bi-folder"></i>
                                    <ul class="cats">
                                        <li><a href="#">{{ $menu->category }}</a></li>
                                    </ul>
                                @endif

                                @if ($menu->tags)
                                    <i class="bi bi-tags"></i>
                                    <ul class="tags">
                                        @foreach (explode(',', $menu->tags) as $tag)
                                            <li><a href="#">{{ trim($tag) }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div><!-- End meta bottom -->

                        </article>

                    </div>
                </section><!-- /Blog Details Section -->

                <!-- Blog Author Section -->
                <section id="blog-author" class="blog-author section">
                    <div class="container">
                        <div class="author-container d-flex align-items-center">

                            <!-- Logo / Author Image -->
                            <img src="{{ Storage::url(general_setting('logo', 'default-logo.png')) }}"
                                class="rounded-circle flex-shrink-0" alt="{{ general_setting('site_name', 'Site') }}">

                            <div class="ms-3">
                                <!-- Site Name as Author -->
                                <h4>{{ general_setting('site_name', 'Site Name') }}</h4>

                                <!-- Social Links -->
                                <div class="social-links">
                                    @if (general_setting('twitter_url'))
                                        <a href="{{ general_setting('twitter_url') }}"><i class="bi bi-twitter-x"></i></a>
                                    @endif
                                    @if (general_setting('facebook_url'))
                                        <a href="{{ general_setting('facebook_url') }}"><i class="bi bi-facebook"></i></a>
                                    @endif
                                    @if (general_setting('linkedin_url'))
                                        <a href="{{ general_setting('linkedin_url') }}"><i class="bi bi-linkedin"></i></a>
                                    @endif
                                </div>

                                <!-- Optional Tagline or Bio -->
                                <p>{{ general_setting('tagline', 'Welcome to our website!') }}</p>
                            </div>

                        </div>
                    </div>
                </section><!-- /Blog Author Section -->


            </div>
        </div>
    </div>

@endsection
