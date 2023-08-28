@extends('admin.layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Services / List</h1>
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

                {{-- Alert Message code --}}

                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif

                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                {{-- Alert Message code --}}

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <a href="{{ route('service.create.form') }}" class="btn btn-primary">Create</a>
                            </div>
                            <div class="card-tools">
                                <form action="" method="get">
                                    <div class="input-group mb-0 mt-0" style="width: 250px;">
                                        <input type="text" name="keyword" value="{{ (!empty(Request::get('keyword'))) ? Request::get('keyword') : '' }}" class="form-control float-right" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table">
                                <tr>
                                    <th width="50">Id</th>
                                    <th width="80">Image</th>
                                    <th>Title</th>
                                    <th width="100">Created</th>
                                    <th width="100"> Status</th>
                                    <th width="100">Actions</th>
                                </tr>
                                @if (!empty($services))

                                @foreach ($services as $service)

                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td>
                                        @if(!empty($service->image))
                                        <img src="{{ asset('uploads/temp/services/thumb/small/'.$service->image) }}" width="50" alt="">
                                        @else
                                        <img src="{{ asset('uploads/temp/placeholder.jpg') }}" width="50" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ date('d/m/Y',strtotime($service->created_at)) }}</td>
                                    <td>
                                        @if($service->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Block</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('service.edit',$service->id)}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" height="25" width="25"><path d="M 25 4.03125 C 24.234375 4.03125 23.484375 4.328125 22.90625 4.90625 L 13 14.78125 L 12.78125 15 L 12.71875 15.3125 L 12.03125 18.8125 L 11.71875 20.28125 L 13.1875 19.96875 L 16.6875 19.28125 L 17 19.21875 L 17.21875 19 L 27.09375 9.09375 C 28.246094 7.941406 28.246094 6.058594 27.09375 4.90625 C 26.515625 4.328125 25.765625 4.03125 25 4.03125 Z M 25 5.96875 C 25.234375 5.96875 25.464844 6.089844 25.6875 6.3125 C 26.132813 6.757813 26.132813 7.242188 25.6875 7.6875 L 16 17.375 L 14.28125 17.71875 L 14.625 16 L 24.3125 6.3125 C 24.535156 6.089844 24.765625 5.96875 25 5.96875 Z M 4 8 L 4 28 L 24 28 L 24 14.8125 L 22 16.8125 L 22 26 L 6 26 L 6 10 L 15.1875 10 L 17.1875 8 Z" fill="#0077b6" style=""></path></svg>
                                        </a>
                                        &nbsp;
                                    <a href="javascript:void(0);" onclick="deleteService({{ $service->id }});">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="25" width="25">
                                            <g fill="#fb6f92" style="">
                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                            <path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zM9 4v2h6V4H9z" fill="#fb6f92" style=""></path>
                                            </g>
                                            </svg>
                                    </a>
                                    </td>
                                </tr>
                                @endforeach

                                @else

                                <tr>
                                    <td colspan="6">Records Not Found</td>
                                </tr>

                                @endif
                            </table>
                        </div>
                    </div>

                    {{-- @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif --}}
                </div>
            </div>
            <!-- /.row -->
            <!-- /.row (main row) -->

            <div class="row">
                @if(!empty($services))
                {{ $services->links('pagination::bootstrap-4') }}
                @endif

            </div>


        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

    @section('extraJs')
            <script type="text/javascript">
                function deleteService(id)
                {
                    if(confirm("Are you sure you want to delete?"))
                    {

                        $.ajax({
                            url: '{{ url("/admin/services/delete") }}/'+id,
                            type: 'POST',
                            dataType: 'json',
                            data: {},

                            // headers: {
                            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            // },
                            success: function(response) {
                                // Your success handling
                                window.location.href="{{ route('serviceList') }}";
                            }
                        });


                    }
                }
            </script>
    @endsection
