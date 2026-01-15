@extends('admin.layouts.app')

@section('title', 'বার্তা দেখুন')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">বার্তা দেখুন</h1>

    <div class="card mb-4">
        <div class="card-header">
            <strong>{{ $contactMessage->name }}</strong> 
            <small>{{ $contactMessage->created_at->format('d M, Y H:i') }}</small>
        </div>
        <div class="card-body">
            <p><strong>ইমেইল:</strong> {{ $contactMessage->email ?? '-' }}</p>
            <p><strong>ফোন:</strong> {{ $contactMessage->phone ?? '-' }}</p>
            <p><strong>বিষয়:</strong> {{ $contactMessage->subject ?? '-' }}</p>
            <p><strong>বার্তা:</strong><br>{{ $contactMessage->message }}</p>
        </div>
    </div>

    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">পেছনে</a>
</div>
@endsection
