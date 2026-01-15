@extends('layouts.web')

@section('title', $job->title)

@push('styles')
<style>
    /* Section background */
    .job-detail-section {
        background-color: #f8f9fa; /* light gray background */
        padding: 60px 0;
    }

    /* Job card */
    .job-card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .job-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    /* Job Title */
    .job-card h1 {
        color: #0d6efd;
        font-weight: 600;
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    /* Job meta info */
    .job-meta p {
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .job-meta strong {
        color: #0d6efd;
    }

    /* Job description */
    .job-description {
        margin-top: 1rem;
        margin-bottom: 1.5rem;
        line-height: 1.7;
        color: #495057;
    }

    /* Job file */
    .job-file a, .job-file img {
        margin-top: 0.5rem;
        display: inline-block;
    }

    /* Apply section */
    .apply-section {
        margin-top: 2.5rem;
        padding: 1.8rem;
        background-color: #e9f2ff; /* subtle blue */
        border-radius: 0.5rem;
        border-left: 5px solid #0d6efd;
    }

    .apply-section h4 {
        color: #0d6efd;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .apply-section .form-control {
        margin-bottom: 1rem;
    }

    .apply-section small {
        display: block;
        color: #6c757d;
        margin-top: -0.5rem;
        margin-bottom: 0.5rem;
    }

    .btn-submit {
        width: 100%;
    }

    /* Success message */
    .alert-success {
        margin-bottom: 1.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .apply-section {
            padding: 1rem;
        }
        .job-card h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<section class="job-detail-section">
    <div class="container">
        <div class="job-card">
            
            {{-- Job Title --}}
            <h1>{{ $job->title }}</h1>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Job Meta --}}
            <div class="job-meta mb-3">
                <p><strong>Department:</strong> {{ $job->department ?? '-' }}</p>
                <p><strong>Vacancy:</strong> {{ $job->vacancy_count ?? '-' }}</p>
                <p><strong>Application Deadline:</strong> {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M Y') }}</p>
                <p><strong>Published Date:</strong> {{ optional($job->published_date)->format('d M Y') ?? '-' }}</p>
            </div>

            {{-- Job Description --}}
            @if($job->description)
                <div class="job-description">
                    {!! nl2br($job->description) !!}
                </div>
            @endif

            {{-- Job File --}}
            @if($job->file)
                <div class="job-file mb-3">
                    @if($job->file_type == 'pdf')
                        <a href="{{ asset('storage/'.$job->file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            Download PDF
                        </a>
                    @else
                        <img src="{{ asset('storage/'.$job->file) }}" alt="Job File" class="img-fluid rounded">
                    @endif
                </div>
            @endif

            {{-- Apply Section --}}
            <div class="apply-section">
                <h4>Apply for this Job</h4>
                <form action="{{ route('web.jobs.apply', $job->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="text" name="phone" class="form-control" placeholder="Phone">
                        </div>
                        <div class="col-md-6">
                            <input type="file" name="resume" class="form-control" required>
                            <small>Upload your resume (PDF/DOC/DOCX)</small>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <input type="file" name="cover_letter" class="form-control">
                            <small>Optional: Cover Letter (PDF/DOC/DOCX)</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-submit mt-3">Submit Application</button>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection
