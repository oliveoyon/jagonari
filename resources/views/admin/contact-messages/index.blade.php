@extends('admin.layouts.app')

@section('title', 'যোগাযোগ বার্তা')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">যোগাযোগ বার্তা</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Buttons --}}
    <div class="mb-3">
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary btn-sm">সব</a>
        <a href="{{ route('admin.contact-messages.index', ['filter' => 'pending']) }}" class="btn btn-warning btn-sm">অপেক্ষমান</a>
        <a href="{{ route('admin.contact-messages.index', ['filter' => 'read']) }}" class="btn btn-success btn-sm">পড়া হয়েছে</a>
    </div>

    {{-- Messages Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>নাম</th>
                <th>ইমেইল</th>
                <th>বিষয়</th>
                <th>স্ট্যাটাস</th>
                <th>প্রাপ্তির তারিখ</th>
                <th>ক্রিয়া</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
            <tr @if($message->is_read == 0) class="table-warning" @endif>
                <td>{{ $message->name }}</td>
                <td>{{ $message->email }}</td>
                <td>{{ $message->subject }}</td>
                <td>
                    @if($message->is_read == 0)
                        <span class="badge bg-warning">অপেক্ষমান</span>
                    @else
                        <span class="badge bg-success">পড়া হয়েছে</span>
                    @endif
                </td>
                <td>{{ $message->created_at->format('d M Y, h:i A') }}</td>
                <td>
                    <a href="{{ route('admin.contact-messages.show', $message->id) }}" class="btn btn-sm btn-primary">দেখুন</a>
                    <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">মুছুন</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">কোনো বার্তা পাওয়া যায়নি।</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
