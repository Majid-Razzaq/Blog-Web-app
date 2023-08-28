@extends('layouts.app')

@section('content')
<section class="hero-small">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url({{asset('assets/images/banner1.jpg') }}) ;">
                <div class="hero-small-background-overlay"></div>
                <div class="container  h-100">
                    <div class="row align-items-center d-flex h-100">
                        <div class="col-md-12">
                            <div class="block text-center">
                                <span class="text-uppercase text-sm letter-spacing"></span>
                                <h1 class="mb-3 mt-3 text-center">Contact us</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-5 pb-0" >
    <div class="container contact-box">
        <div class="row">
            <div class="col-lg-8 col-xl-6 text-center mx-auto">
                <h1 class="mb-4 text-black">We're here to help!</h1>
            </div>
        </div>

        <!-- Contact info box -->
        <div class="row g-4 g-md-5 mt-0 mt-lg-3">
            <!-- Box item -->
            @if(!empty($settings) && $settings->contact_card_one != '' )

            <div class="col-lg-4 mt-lg-0">
                <div class="card card-body bg-primary shadow py-5 text-center h-100 border-0 text-white card-one">

                    {!! $settings->contact_card_one !!}

                </div>
            </div>

            @endif

            <!-- Box item -->
            @if(!empty($settings) && $settings->contact_card_two != '' )
            <div class="col-lg-4 mt-lg-0">
                <div class="card card-body shadow py-5 text-center h-100 border-0 ">
                    {!! $settings->contact_card_two !!}
                </div>
            </div>
            @endif


            <!-- Box item -->
            @if(!empty($settings) && $settings->contact_card_three != '' )
            <div class="col-lg-4 mt-lg-0">
                <div class="card card-body shadow py-5 text-center h-100 border-0">
                    {!! $settings->contact_card_three !!}
                </div>
            </div>
            @endif

        </div>
    </div>
</section>

<section>
    <div class="container my-5">
        <div class="row g-4 g-lg-0 align-items-center">

            <!-- Contact form START -->
            <div class="col-md-12">
                <!-- Title -->
                <h2 class="mt-4 mt-md-0">Let's talk</h2>
                <p>Have questions or need a quote? Reach out to us directly or use the form, and we'll respond promptly.</p>

                <form method="post" id="sendForm" name="sendForm">
                    <!-- Name -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4 bg-light-input">
                                <label for="yourName" class="form-label">Your name *</label>
                                <input type="text" class="form-control form-control-lg" name="name" id="name">
                                <p class="text-danger error name-error"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4 bg-light-input">
                                <label for="emailInput" class="form-label">Email address *</label>
                                <input type="email" class="form-control form-control-lg" name="email" id="email" >
                                <p class="text-danger error email-error"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="mb-4 bg-light-input">
                        <label for="textareaBox" class="form-label">Message *</label>
                        <textarea class="form-control" name="message" id="message" rows="4"></textarea>
                        <p class="text-danger error message-error"></p>
                    </div>
                    <!-- Button -->
                    <div class="d-grid">
                        <button name="submit" type="submit" class="btn btn-lg btn-primary mb-0">Send Message</button>

                    </div>
                </form>

                @if(Session::has('success'))
                <div class="alert alert-success mt-2">
                    {{ Session::get('success') }}
                </div>
                @endif

            </div>
            <!-- Contact form END -->
        </div>
    </div>
</section>

<section class="pt-0 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <iframe class="w-100 h-400px grayscale rounded" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1416.1741414436744!2d67.267613!3d24.885238!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb3314c8a5571dd%3A0xa0ca32d38df0fa37!2sJam%20Kando%20Bin%20Qasim%20Town%2C%20Karachi%2C%20Karachi%20City%2C%20Sindh%2C%20Pakistan!5e1!3m2!1sen!2sus!4v1693223308053!5m2!1sen!2sus" height="500" style="border:0;" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection



@section('extraJs')

<script type="text/javascript">

$("#sendForm").submit(function(event) {
    event.preventDefault();

    $("button[type='submit']").prop('disabled',true);

    $.ajax({
    url: '{{ route("form.save") }}',
    type: 'POST',
    dataType: 'json',
    data: $("#sendForm").serializeArray(),

    // headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    // },
    success: function(response) {
        // Your success handling
        if(response.status == 200)
        {
            $("button[type='submit']").prop('disabled',false);

            // No errors
            window.location.href = '{{ url("/contact") }}';

        }
        else
        {
            // here wi wil show errors
            $('.name-error').html(response.errors.name);
            $('.email-error').html(response.errors.email);
            $('.message-error').html(response.errors.message);

        }
    }
});

});



</script>
@endsection
