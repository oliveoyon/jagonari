@extends('admin.layouts.app')

@section('title', 'সাধারণ তথ্য সেটিংস')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">সাধারণ তথ্য সেটিংস</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.general-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Row 1: Site Name, Tagline, Phone1 --}}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>সাইট নাম</label>
                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $setting->site_name ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ট্যাগলাইন</label>
                    <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $setting->tagline ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ফোন ১</label>
                    <input type="text" name="phone1" class="form-control" value="{{ old('phone1', $setting->phone1 ?? '') }}">
                </div>
            </div>
        </div>

        {{-- Row 2: Phone2, Email1, Email2 --}}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>ফোন ২</label>
                    <input type="text" name="phone2" class="form-control" value="{{ old('phone2', $setting->phone2 ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ইমেইল ১</label>
                    <input type="email" name="email1" class="form-control" value="{{ old('email1', $setting->email1 ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ইমেইল ২</label>
                    <input type="email" name="email2" class="form-control" value="{{ old('email2', $setting->email2 ?? '') }}">
                </div>
            </div>
        </div>

        {{-- Row 3: Address --}}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>ঠিকানা</label>
                    <textarea name="address" class="form-control" rows="3">{{ old('address', $setting->address ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Row 4: Footer Text, Google Map URL --}}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>ফুটার লাইন</label>
                    <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $setting->footer_text ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Google Map URL</label>
                    <input type="text" name="google_map_url" class="form-control" value="{{ old('google_map_url', $setting->google_map_url ?? '') }}">
                </div>
            </div>
        </div>

        {{-- Row 5: Social Links --}}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Facebook URL</label>
                    <input type="text" name="facebook_url" class="form-control" value="{{ old('facebook_url', $setting->facebook_url ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Twitter URL</label>
                    <input type="text" name="twitter_url" class="form-control" value="{{ old('twitter_url', $setting->twitter_url ?? '') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>LinkedIn URL</label>
                    <input type="text" name="linkedin_url" class="form-control" value="{{ old('linkedin_url', $setting->linkedin_url ?? '') }}">
                </div>
            </div>
        </div>

        {{-- Row 6: Logo, Favicon --}}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>লোগো</label>
                    <input type="file" name="logo" class="form-control mb-2">
                    @if(!empty($setting->logo))
                        <a href="#" data-toggle="modal" data-target="#logoModal">
                            <img src="{{ asset('storage/'.$setting->logo) }}" width="100" class="img-thumbnail">
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>ফ্যাভিকন</label>
                    <input type="file" name="favicon" class="form-control mb-2">
                    @if(!empty($setting->favicon))
                        <a href="#" data-toggle="modal" data-target="#faviconModal">
                            <img src="{{ asset('storage/'.$setting->favicon) }}" width="50" class="img-thumbnail">
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">আপডেট করুন</button>
    </form>
</div>

{{-- Logo Modal --}}
@if(!empty($setting->logo))
<div class="modal fade" id="logoModal" tabindex="-1" role="dialog" aria-labelledby="logoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoModalLabel">লোগো পূর্ণ পরিসর</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="বন্ধ করুন">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('storage/'.$setting->logo) }}" class="img-fluid">
      </div>
    </div>
  </div>
</div>
@endif

{{-- Favicon Modal --}}
@if(!empty($setting->favicon))
<div class="modal fade" id="faviconModal" tabindex="-1" role="dialog" aria-labelledby="faviconModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="faviconModalLabel">ফ্যাভিকন পূর্ণ পরিসর</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="বন্ধ করুন">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('storage/'.$setting->favicon) }}" class="img-fluid">
      </div>
    </div>
  </div>
</div>
@endif

@endsection
