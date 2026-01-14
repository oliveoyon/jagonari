@extends('admin.layouts.app')

@section('title', 'টিম মেম্বার ম্যানেজমেন্ট')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">টিম মেম্বার ম্যানেজমেন্ট</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Add new form --}}
    <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3"><input type="text" name="name" placeholder="নাম" class="form-control" required></div>
            <div class="col-md-3"><input type="text" name="designation" placeholder="পদবী" class="form-control"></div>
            <div class="col-md-2"><input type="email" name="email" placeholder="ইমেইল" class="form-control"></div>
            <div class="col-md-2"><input type="text" name="phone" placeholder="ফোন" class="form-control"></div>
            <div class="col-md-2"><input type="file" name="image" class="form-control"></div>
            <div class="col-md-12 mt-2">
                <button class="btn btn-success" type="submit">যোগ করুন</button>
            </div>
        </div>
    </form>

    {{-- Team Members Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>নাম</th>
                <th>পদবী</th>
                <th>ইমেইল</th>
                <th>ফোন</th>
                <th>ছবি</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teamMembers as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->designation }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->phone }}</td>
                <td>
                    @if($member->image)
                        <a href="{{ asset('storage/'.$member->image) }}" target="_blank">
                            <img src="{{ asset('storage/'.$member->image) }}" width="50">
                        </a>
                    @endif
                </td>
                <td>
                    {{-- Edit Button triggers modal --}}
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $member->id }}">এডিট</button>

                    {{-- Delete Form --}}
                    <form action="{{ route('admin.team-members.destroy', $member->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">মুছুন</button>
                    </form>
                </td>
            </tr>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">টিম মেম্বার এডিট</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('admin.team-members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>নাম</label>
                            <input type="text" name="name" class="form-control" value="{{ $member->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>পদবী</label>
                            <input type="text" name="designation" class="form-control" value="{{ $member->designation }}">
                        </div>
                        <div class="form-group">
                            <label>ইমেইল</label>
                            <input type="email" name="email" class="form-control" value="{{ $member->email }}">
                        </div>
                        <div class="form-group">
                            <label>ফোন</label>
                            <input type="text" name="phone" class="form-control" value="{{ $member->phone }}">
                        </div>
                        <div class="form-group">
                            <label>ছবি</label>
                            <input type="file" name="image" class="form-control mb-2">
                            @if($member->image)
                                <img src="{{ asset('storage/'.$member->image) }}" width="80">
                            @endif
                        </div>
                        <button class="btn btn-success" type="submit">আপডেট</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>
@endsection
