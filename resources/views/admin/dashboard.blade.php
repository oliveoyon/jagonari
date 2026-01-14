@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-3">ড্যাশবোর্ড</h1>

        <div class="card">
            <div class="card-body">
                Welcome, {{ auth()->user()->name }}
            </div>
        </div>
    </div>
@endsection
