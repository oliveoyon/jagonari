@extends('admin.layouts.app')

@section('title', 'মেনু ম্যানেজমেন্ট')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">মেনু ম্যানেজমেন্ট</h1>

    <div class="mb-3">
        <button class="btn btn-primary" id="addNewMenu">নতুন মেনু যোগ করুন</button>
    </div>

    {{-- Filter --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label>মেনু ফিল্টার</label>
            <select id="menuFilter" class="form-control">
                <option value="">-- সকল মেনু --</option>
                @foreach($menus->where('parent_id', null) as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-bordered" id="menuTable">
        <thead>
            <tr>
                <th>আইডি</th>
                <th>শিরোনাম</th>
                <th>URL Slug</th>
                <th>প্যারেন্ট মেনু</th>
                <th>ক্রম</th>
                <th>স্ট্যাটাস</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody id="menuTableBody">
            @foreach($menus as $menu)
            <tr data-parent="{{ $menu->parent_id ?? 0 }}" id="menuRow{{ $menu->id }}">
                <td>{{ $menu->id }}</td>
                <td>{{ $menu->title }}</td>
                <td>{{ $menu->slug }}</td>
                <td>{{ $menu->parent?->title ?? '-' }}</td>
                <td>{{ $menu->display_order }}</td>
                <td>{{ $menu->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</td>
                <td>
                    <button class="btn btn-sm btn-info editMenu" data-id="{{ $menu->id }}">সম্পাদনা</button>
                    <button class="btn btn-sm btn-danger deleteMenu" data-id="{{ $menu->id }}">মুছুন</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal --}}
<div class="modal fade" id="menuModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form id="menuForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="menu_id" id="menuId">

            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">নতুন মেনু যোগ করুন</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>শিরোনাম</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Slug (Bangla URL)</label>
                    <input type="text" name="slug" id="slug" class="form-control">
                </div>

                <div class="form-group">
                    <label>প্যারেন্ট মেনু (সাবমেনু হলে)</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">-- কোনটিই নয় --</option>
                        @foreach($menus->where('parent_id', null) as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>ক্রম</label>
                    <input type="number" name="display_order" id="display_order" class="form-control">
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" checked>
                    <label class="form-check-label">সক্রিয়</label>
                </div>

                <div class="form-group">
                    <label>মূল ছবি (ঐচ্ছিক)</label>
                    <input type="file" name="main_image" id="main_image" class="form-control">
                    <div id="currentImage" class="mt-2"></div>
                </div>

                <div class="form-group">
                    <label>বিস্তারিত বিবরণ</label>
                    <textarea name="content" id="content" class="form-control" rows="5"></textarea>
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

{{-- Scripts --}}
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
$(document).ready(function() {

    // Initialize Summernote
    $('#content').summernote({
        height: 200,
        callbacks: {
            onImageUpload: function(files) {
                let formData = new FormData();
                formData.append('file', files[0]);
                axios.post('/admin/menus/upload-image', formData)
                    .then(res => {
                        $('#content').summernote('insertImage', res.data.url);
                    })
                    .catch(err => console.log(err));
            }
        }
    });

    // Open Add Modal
    $('#addNewMenu').click(function() {
        $('#menuForm')[0].reset();
        $('#menuId').val('');
        $('#modalTitle').text('নতুন মেনু যোগ করুন');
        $('#currentImage').html('');
        $('#content').summernote('code', '');
        $('#menuModal').modal('show');
    });

    // Menu Filter Dependent
    $('#menuFilter').change(function(){
        let parentId = $(this).val();
        if(parentId == ''){
            $('#menuTableBody tr').show();
        } else {
            $('#menuTableBody tr').each(function(){
                $(this).toggle($(this).data('parent') == parentId);
            });
        }
    });

    // Store / Update
    $('#menuForm').submit(function(e){
        e.preventDefault();

        let menuId = $('#menuId').val();
        let url = menuId ? `/admin/menus/${menuId}` : `/admin/menus`;

        let formData = new FormData(this);
        formData.set('_method', menuId ? 'PUT' : 'POST');
        formData.set('content', $('#content').summernote('code'));
        formData.set('is_active', $('#is_active').is(':checked') ? 1 : 0);

        axios.post(url, formData)
            .then(res => {
                alert(res.data.message);
                location.reload();
            })
            .catch(err => {
                if(err.response.status === 422){
                    let errors = err.response.data.errors;
                    let msg = '';
                    for(let key in errors){ msg += errors[key][0] + "\n"; }
                    alert(msg);
                } else { alert('ত্রুটি ঘটেছে!'); }
            });
    });

    // Edit
    $(document).on('click', '.editMenu', function(){
        let menuId = $(this).data('id');
        axios.get(`/admin/menus/${menuId}`)
            .then(res => {
                let menu = res.data;
                $('#menuId').val(menu.id);
                $('#title').val(menu.title);
                $('#slug').val(menu.slug);
                $('#parent_id').val(menu.parent_id);
                $('#display_order').val(menu.display_order);
                $('#is_active').prop('checked', menu.is_active);
                $('#currentImage').html(menu.main_image ? `<img src="/storage/${menu.main_image}" width="100">` : '');
                $('#content').summernote('code', menu.content ?? '');
                $('#modalTitle').text('মেনু সম্পাদনা করুন');
                $('#menuModal').modal('show');
            })
            .catch(err => alert('ডেটা লোড করতে ব্যর্থ হয়েছে।'));
    });

    // Delete
    $(document).on('click', '.deleteMenu', function(){
        if(!confirm('আপনি কি সত্যিই এই মেনুটি মুছে ফেলতে চান?')) return;
        let menuId = $(this).data('id');
        axios.delete(`/admin/menus/${menuId}`)
            .then(res => {
                alert(res.data.message);
                $('#menuRow'+menuId).remove();
            })
            .catch(err => alert('মুছতে ব্যর্থ হয়েছে!'));
    });

});
</script>
@endpush
