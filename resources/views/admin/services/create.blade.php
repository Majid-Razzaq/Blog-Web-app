@extends('admin.layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Services / Create</h1>
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
                    <form method="post" name="createServiceForm" id="createServiceForm">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('serviceList') }}" class="btn btn-primary">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <p class="error name-error"></p>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="summernote"></textarea>
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
                                    </div>

                                    <div class="col-md-6">
                                        <label>Short Description</label>
                                        <textarea name="short_description" id="short_description" cols="30" rows="7" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
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

$("#createServiceForm").submit(function(event) {
    event.preventDefault();

    $("button[type='submit']").prop('disabled',true);

    $.ajax({
    url: '{{ route("service.create") }}',
    type: 'POST',
    dataType: 'json',
    data: $("#createServiceForm").serializeArray(),

    // headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    // },
    success: function(response) {
        // Your success handling
        if(response.status == 200)
        {
            $("button[type='submit']").prop('disabled',false);

            // No errors
            window.location.href = '{{ route("serviceList") }}';

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
