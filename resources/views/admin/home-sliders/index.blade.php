@extends('admin.layouts.app')

@section('title', 'হোম স্লাইডার ম্যানেজমেন্ট')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-3">হোম স্লাইডার</h1>

        <button class="btn btn-primary mb-3" id="addNewSlider">
            নতুন স্লাইডার যোগ করুন
        </button>

        <table class="table table-bordered" id="sliderTable">
            <thead>
                <tr>
                    <th>আইডি</th>
                    <th>ছবি</th>
                    <th>শিরোনাম</th>
                    <th>সংক্ষিপ্ত বিবরণ</th>
                    <th>ক্রম</th>
                    <th>স্ট্যাটাস</th>
                    <th>অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sliders as $slider)
                    <tr id="sliderRow{{ $slider->id }}">
                        <td>{{ $slider->id }}</td>
                        <td><img src="{{ asset('storage/' . $slider->image) }}" width="100"></td>
                        <td>{{ $slider->title }}</td>
                        <td>{{ $slider->short_description }}</td>
                        <td>{{ $slider->display_order }}</td>
                        <td>{{ $slider->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info editSlider" data-id="{{ $slider->id }}">সম্পাদনা</button>
                            <button class="btn btn-sm btn-danger deleteSlider" data-id="{{ $slider->id }}">মুছুন</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="sliderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="sliderForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="slider_id" id="sliderId">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">নতুন স্লাইডার যোগ করুন</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>শিরোনাম</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>সংক্ষিপ্ত বিবরণ</label>
                            <textarea name="short_description" id="short_description" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>বিস্তারিত বিবরণ</label>
                            <textarea name="long_description" id="long_description" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>ছবি</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <div id="currentImage" class="mt-2"></div>
                        </div>

                        <div class="form-group">
                            <label>ক্রম</label>
                            <input type="number" name="display_order" id="display_order" class="form-control">
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" checked>
                            <label class="form-check-label">সক্রিয়</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="saveBtn">সংরক্ষণ করুন</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Push scripts --}}
@push('scripts')
    <!-- Summernote CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {

            // Initialize Summernote
            $('#long_description').summernote({
                height: 200
            });

            // Open Add Modal
            $('#addNewSlider').click(function() {
                $('#sliderForm')[0].reset();
                $('#sliderId').val('');
                $('#modalTitle').text('নতুন স্লাইডার যোগ করুন');
                $('#currentImage').html('');
                $('#long_description').summernote('code', '');
                $('#sliderModal').modal('show');
            });

            // Store / Update Slider
            $('#sliderForm').submit(function(e) {
                e.preventDefault();

                let sliderId = $('#sliderId').val();
                let url = sliderId ? `/admin/home-sliders/${sliderId}` : `/admin/home-sliders`;

                let formData = new FormData(this);
                formData.set('_method', sliderId ? 'PUT' : 'POST');
                formData.set('long_description', $('#long_description').summernote('code'));
                formData.set('is_active', $('#is_active').is(':checked') ? 1 : 0);

                axios.post(url, formData)
                    .then(function(response) {
                        alert(response.data.message);
                        location.reload();
                    })
                    .catch(function(error) {
                        if (error.response.status === 422) {
                            // Show validation errors
                            let errors = error.response.data.errors;
                            let msg = '';
                            for (let key in errors) {
                                msg += errors[key][0] + "\n";
                            }
                            alert(msg);
                        } else {
                            alert('ত্রুটি ঘটেছে!');
                        }
                    });
            });


            // Edit Slider
            $(document).on('click', '.editSlider', function() {
                let sliderId = $(this).data('id');
                axios.get(`/admin/home-sliders/${sliderId}`)
                    .then(function(response) {
                        let slider = response.data;
                        $('#sliderId').val(slider.id);
                        $('#title').val(slider.title);
                        $('#short_description').val(slider.short_description);
                        $('#long_description').summernote('code', slider.long_description);
                        $('#display_order').val(slider.display_order);
                        $('#is_active').prop('checked', slider.is_active);
                        $('#currentImage').html(slider.image ?
                            `<img src="/storage/${slider.image}" width="100">` : '');
                        $('#modalTitle').text('স্লাইডার সম্পাদনা করুন');
                        $('#sliderModal').modal('show');
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert('ডেটা লোড করতে ব্যর্থ হয়েছে।');
                    });
            });

            // Delete Slider
            $(document).on('click', '.deleteSlider', function() {
                if (!confirm('আপনি কি সত্যিই এই স্লাইডারটি মুছে ফেলতে চান?')) return;
                let sliderId = $(this).data('id');

                axios.delete(`/admin/home-sliders/${sliderId}`)
                    .then(function(response) {
                        alert(response.data.message);
                        $('#sliderRow' + sliderId).remove();
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert('মুছতে ব্যর্থ হয়েছে!');
                    });
            });

        });
    </script>
@endpush
