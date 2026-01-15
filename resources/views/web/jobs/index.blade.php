@extends('layouts.web')

@section('title', 'Job Circulars')

@push('styles')
<style>
    /* Section background */
    .job-section {
        background-color: #f4f6f8; /* light gray */
        padding: 60px 0;
    }

    /* Table styles */
    .job-table {
        color: #212529; /* dark text */
    }

    .job-table thead {
        background-color: #0d6efd;
        color: #fff;
    }

    .job-table tbody tr:hover {
        background-color: #e9f2ff;
    }

    .job-table th, .job-table td {
        vertical-align: middle;
    }

    /* Badges */
    .badge-deadline {
        background-color: #ffc107;
        color: #212529; /* dark text */
        font-size: 0.85rem;
    }

    .badge-department {
        background-color: #0dcaf0;
        color: #212529; /* dark text */
        font-size: 0.85rem;
    }

    .badge-vacancy {
        background-color: #6c757d;
        color: #fff; /* keep white for contrast */
        font-size: 0.85rem;
    }

    .badge-published {
        background-color: #198754;
        color: #fff;
        font-size: 0.85rem;
    }

    .apply-btn {
        white-space: nowrap;
    }

    .job-section h1 {
        color: #0d6efd;
        font-weight: 600;
        text-align: center;
        margin-bottom: 2rem;
    }
</style>
@endpush

@section('content')
<section class="job-section">
    <div class="container">
        <h1>চাকরির সুযোগ</h1>

        @if($jobs->isEmpty())
            <p class="text-center text-muted">এই মুহূর্তে কোনো চাকরির সুযোগ পাওয়া যায়নি।</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover job-table align-middle">
                    <thead>
                        <tr>
                            <th>শিরোনাম</th>
                            <th>বিভাগ</th>
                            <th>শূন্যপদ</th>
                            <th>প্রকাশের তারিখ</th>
                            <th>শেষ তারিখ</th>
                            <th>ফাইল</th>
                            <th>অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            @if($job->status)
                            <tr>
                                <td>
                                    <a href="{{ route('web.jobs.detail', $job->slug) }}" class="text-dark text-decoration-none fw-semibold">
                                        {{ $job->title }}
                                    </a>
                                    @if($job->description)
                                        <p class="text-muted mb-0" style="font-size: 0.85rem; text-dark">
                                            {{ \Illuminate\Support\Str::limit($job->description, 100) }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    @if($job->department)
                                        <span class="badge badge-department text-dark">{{ $job->department }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($job->vacancy_count)
                                        <span class="badge badge-vacancy text-dark">{{ $job->vacancy_count }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-published text-dark">
                                        {{ \Carbon\Carbon::parse($job->published_date)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-deadline text-dark">
                                        {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if($job->file)
                                        <a href="{{ asset('storage/'.$job->file) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                            @if($job->file_type == 'pdf') PDF ডাউনলোড @else ছবি দেখুন @endif
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('web.jobs.detail', $job->slug) }}" class="btn btn-success btn-sm apply-btn">এখন আবেদন করুন</a>
                                    
                                </td>
                                

                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
