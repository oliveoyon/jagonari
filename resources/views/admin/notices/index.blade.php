@extends('admin.layouts.app')

@section('title', 'নোটিশ বোর্ড')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">নোটিশ বোর্ড</h1>

    <button class="btn btn-primary mb-3" id="addNewNotice">
        নতুন নোটিশ যোগ করুন
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>আইডি</th>
                <th>শিরোনাম</th>
                <th>সংযুক্তি</th>
                <th>স্ট্যাটাস</th>
                <th>অ্যাকশন</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notices as $notice)
                <tr id="noticeRow{{ $notice->id }}">
                    <td>{{ $notice->id }}</td>
                    <td>{{ $notice->title }}</td>
                    <td>
                        @if($notice->attachment)
                            @if($notice->attachment_type === 'image')
                                <img src="{{ asset('storage/'.$notice->attachment) }}" width="80">
                            @else
                                <a href="{{ asset('storage/'.$notice->attachment) }}" target="_blank">
                                    PDF দেখুন
                                </a>
                            @endif
                        @endif
                    </td>
                    <td>{{ $notice->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</td>
                    <td>
                        <button class="btn btn-sm btn-info editNotice"
                                data-id="{{ $notice->id }}">সম্পাদনা</button>
                        <button class="btn btn-sm btn-danger deleteNotice"
                                data-id="{{ $notice->id }}">মুছুন</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal --}}
<div class="modal fade" id="noticeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="noticeForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="noticeId">

                <div class="modal-header">
                    <h5 class="modal-title">নোটিশ</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>শিরোনাম</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>বিবরণ</label>
                        <textarea name="description" id="description"
                                  class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>সংযুক্তি (ছবি / PDF)</label>
                        <input type="file" name="attachment" id="attachment"
                               class="form-control">
                        <div id="currentAttachment" class="mt-2"></div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" id="is_active"
                               class="form-check-input" checked>
                        <label class="form-check-label">সক্রিয়</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">সংরক্ষণ</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">বন্ধ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
$(function(){

    $('#addNewNotice').click(function(){
        $('#noticeForm')[0].reset();
        $('#noticeId').val('');
        $('#currentAttachment').html('');
        $('#noticeModal').modal('show');
    });

    $('#noticeForm').submit(function(e){
        e.preventDefault();

        let id = $('#noticeId').val();
        let url = id ? `/admin/notices/${id}` : `/admin/notices`;

        let formData = new FormData(this);
        formData.set('_method', id ? 'PUT' : 'POST');
        formData.set('is_active', $('#is_active').is(':checked') ? 1 : 0);

        axios.post(url, formData).then(res=>{
            alert(res.data.message);
            location.reload();
        });
    });

    $('.editNotice').click(function(){
        let id = $(this).data('id');
        axios.get(`/admin/notices/${id}`).then(res=>{
            let n = res.data;
            $('#noticeId').val(n.id);
            $('#title').val(n.title);
            $('#description').val(n.description);
            $('#is_active').prop('checked', n.is_active);
            $('#currentAttachment').html(
                n.attachment
                    ? `<a href="/storage/${n.attachment}" target="_blank">বর্তমান ফাইল</a>`
                    : ''
            );
            $('#noticeModal').modal('show');
        });
    });

    $('.deleteNotice').click(function(){
        if(!confirm('নোটিশ মুছে ফেলতে চান?')) return;
        let id = $(this).data('id');

        axios.delete(`/admin/notices/${id}`).then(res=>{
            alert(res.data.message);
            $('#noticeRow'+id).remove();
        });
    });

});
</script>
@endpush
