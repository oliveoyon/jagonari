@extends('admin.layouts.app')

@section('title','Gallery Event Management')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Gallery Event Management</h1>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= Add New Event ================= --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Add New Gallery Event</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.gallery-events.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Event Title <span class="text-danger">*</span></label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title') }}"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Display Order</label>
                        <input type="number"
                               name="display_order"
                               class="form-control"
                               value="{{ old('display_order') }}">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   id="is_active"
                                   checked>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Event
                </button>
            </form>
        </div>
    </div>

    {{-- ================= Events List ================= --}}
    <div class="card">
        <div class="card-header">
            <strong>Gallery Events List</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th width="10%">Order</th>
                        <th width="10%">Active</th>
                        <th width="18%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->description ?? '-' }}</td>
                            <td>{{ $event->display_order }}</td>
                            <td>
                                @if($event->is_active)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.gallery-events.edit', $event->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Edit
                                </a>

                                <form action="{{ route('admin.gallery-events.destroy', $event->id) }}"
                                      method="POST"
                                      class="d-inline-block"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No gallery events found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
