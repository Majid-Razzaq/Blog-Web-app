@extends('admin.layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pages / Edit</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content  h-100">
        <div class="container-fluid  h-100">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <form method="post" name="editPage" id="editPage">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('pageList') }}" class="btn btn-primary">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" value="{{ $page->name }}" name="name" id="name" class="form-control">
                                    <p class="error name-error"></p>
                                </div>

                                <div class="form-group">
                                    <label for="description">Content</label>
                                    <textarea name="content" id="content" class="summernote">{{ $page->content }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="image_id" id="image_id" value="">
                                        <label>Image</label>
                                        <div id="image" class="dropzone dz-clickable text-center">
                                            <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.
                                            <br><br>
                                            </div>
                                        </div>
                                        {{-- Image code --}}
                                        @if(!empty($page->image))
                                        <img class="image-thumbnail my-4" src="{{ asset('uploads/temp/pages/thumb/large/'.$page->image) }}" width="300" height="220" alt="">
                                        <button type="button" class="btn btn-danger" onclick="deletImage({{ $page->id }});">Delete</button>
                                        @else
                                        <img class="image-thumbnail my-4" src="{{ asset('uploads/temp/placeholder.jpg') }}" width="300" height="220" alt="">

                                        @endif
                                        {{-- Image code --}}
                                    </div>

                                </div>

                                <div class="form-group mt-4">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                    <option value="1" {{ ($page->status == 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ ($page->status == 0) ? 'selected' : '' }}>Block</option>
                                </select>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('extraJs')
<script type="text/javascript">

Dropzone.autoDiscover = false;

const dropzone = $("#image").dropzone({
    init: function () {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },
    url: "{{ route('tempUpload') }}",
    maxFiles: 1,
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

    }, success: function (file, response) {
        $("#image_id").val(response.id);
    }
});

// delete Image code
    function deletImage(id)
    {
        if(confirm('Are you sure you want to delete this image?'))
        {
            $.ajax({
                type: "post",
                url:  '{{ route("page.deleteImage") }}',
                data: {id:id},
                dataType: "json",
                success: function (response) {
                    window.location.href='{{ route("page.edit",$page->id) }}';
                }
            });
        }
    }


$("#editPage").submit(function(event) {
    event.preventDefault();

    $("button[type='submit']").prop('disabled',true);

    $.ajax({
    url: '{{ route("page.update",$page->id) }}',
    type: 'POST',
    dataType: 'json',
    data: $("#editPage").serializeArray(),

    // headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    // },
    success: function(response) {
        // Your success handling
        if(response.status == 200)
        {
            $("button[type='submit']").prop('disabled',false);
            // No errors
            window.location.href = '{{ route("pageList") }}';
        }
        else
        {
            // here wi wil show errors
            $('.name-error').html(response.errors.name);

        }
    }
});

});



</script>
@endsection
