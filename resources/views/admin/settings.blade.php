@extends('admin.layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings / Create</h1>
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

                    {{-- Session Message --}}
                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session()->get('success'); }}
                    </div>
                    @endif
                    {{-- Session Message --}}

                    <form method="post" name="settingsForm" id="settingsForm">
                        <div class="card">
                            {{-- <div class="card-header">
                                <a href="{{ route('blogList') }}" class="btn btn-primary">Back</a>
                            </div> --}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Website Title</label>
                                    <input type="text" value="{{ (!empty($settings->website_title)) ? $settings->website_title : ''   }}" name="website_title" id="website_title" class="form-control">
                                    <p class="error title-error"></p>
                                </div>

                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="email" value="{{(!empty($settings->email)) ? $settings->email : '' }}" name="email" id="email" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="name">Phone</label>
                                    <input type="phone" value="{{(!empty($settings->phone)) ? $settings->phone : '' }} " name="phone" id="phone" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="name">Copyright</label>
                                    <input type="text" value="{{(!empty($settings->copy)) ? $settings->copy : '' }} " name="copy" id="copy" class="form-control">
                                </div>

                                <div class="mt-4">
                                <h4><strong>Social Links</strong></h4>
                                <hr>
                                    <div class="form-group">
                                        <label for="name">Facebook Url</label>
                                        <input type="text" value="{{(!empty($settings->facebook_url)) ? $settings->facebook_url : '' }} " name="facebook_url" id="facebook_url" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Twitter Url</label>
                                        <input type="text" value="{{(!empty($settings->twitter_url)) ? $settings->twitter_url : '' }} " name="twitter_url" id="twitter_url" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Instagram Url</label>
                                        <input type="text" value="{{(!empty($settings->instagram_url)) ? $settings->instagram_url : '' }} " name="instagram_url" id="instagram_url" class="form-control">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Contact Card One</label>
                                            <textarea name="contact_card_one" id="contact_card_one" class="summernote">{{ (!empty($settings->contact_card_one)) ? $settings->contact_card_one : '' }} </textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Contact Card Two</label>
                                            <textarea name="contact_card_two" id="contact_card_two" class="summernote">{{(!empty($settings->contact_card_two)) ? $settings->contact_card_two : '' }} </textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Contact Card Three</label>
                                            <textarea name="contact_card_three" id="contact_card_three" class="summernote">{{(!empty($settings->contact_card_three)) ? $settings->contact_card_three : '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Featured Services</label>
                                        <div class="row">
                                            <div class="col">
                                                <select name="service" id="service" class="form-control">

                                                    @if($services)
                                                    @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                    @endif

                                                </select>
                                            </div>

                                            <div class="col">
                                                <button type="button" onclick="addService();" class="btn btn-primary">
                                                    Add Service
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mt-2" id="services-wrapper">
                                                @if($featuredServices->isNotEmpty())
                                                    @foreach ($featuredServices as $service)
                                                      <div class="ui-state-default " data-id='{{ $service->service_id }}' id='service-{{ $service->service_id }}'>
                                                        <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                        {{ $service->name }}
                                                        <button type="button" onclick="deleteService({{ $service->service_id }})" class="btn btn-danger btn-sm">Delete</button>
                                                    </div>
                                                    @endforeach
                                                @endif
                                                {{-- <div class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 1</div> --}}
                                            </div>
                                        </div>

                                    </div>


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

// This function will delete your dropDown services
    function deleteService(id)
    {
        $("#service-"+id).remove();
    }

// jQery code
$( function() {
    $( "#services-wrapper").sortable();
  } );
//   End here

    function addService()
    {
        var serviceId = $("#service").val();
        var serviceName = $("#service option:selected").text();

        var html = `<div class="ui-state-default mt-2" data-id='${serviceId}' id=service-${serviceId}><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>${serviceName}
            <button type="button" onclick="deleteService(${serviceId})" class="btn btn-danger btn-sm">Delete</button>
            </div>`;

        var isFound = false;

        $("#services-wrapper .ui-state-default").each(function(){

            var id = $(this).attr('data-id');
            if(id == serviceId)
            {
                isFound = true;
            }
        });

        if(isFound == true)
        {
            alert("You can not select same service again.");
        }
        else
        {
            $("#services-wrapper").append(html);
        }


    }



$("#settingsForm").submit(function(event) {
    event.preventDefault();

    var servicesString = $("#services-wrapper").sortable('serialize');
    // console.log(servicesString);
    // return false;
    var data = $("#settingsForm").serializeArray();
    data[data.length] = {name: 'services', value : servicesString};

    // $("button[type='submit']").prop('disabled',true);

    $.ajax({
    url: '{{ route("settings.save") }}',
    type: 'POST',
    dataType: 'json',
    data : data,
    // data: $("#settingsForm").serializeArray(),

    success: function(response) {

        $("button[type='submit']").prop('disabled',false);

        // Your success handling
        if(response.status == 200)
        {
            // No errors
            window.location.href = '{{ route("settings.index") }}';
        }
        else
        {
            // here wi wil show errors
            // if(response.errors.website_title)
            // {
                $('.title-error').html(response.errors.website_title);

            // }
            // else
            // {
            //     $('.title-error').html('');
            // }

        }
    }
});

});



</script>
@endsection
