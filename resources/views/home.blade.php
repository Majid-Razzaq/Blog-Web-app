@extends('layouts.app')

@section('content')
<section class="hero">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{asset('assets/images/BlogBanner.png')}}') ;">
                <div class="hero-background-overlay"></div>
                <div class="container h-100">
                    <div class="row align-items-center d-flex h-100">
                        <div class="col-md-7">
                            <div class="block" >
                                <h1 class="mb-3 mt-3">Explore Our Laravel Web App's Blogs for a Complete Experience.</h1>
                                <p class="mb-4 pr-5">Discover a range of top-notch services and delve into insightful blog articles on our feature-rich Laravel web app. Elevate your knowledge and experience all in one place.</p>
                                <div class="btn-container ">
                                    <a href="{{ url('/contact') }}" class="btn btn-primary">Contact Now <i class="icofont-simple-right ml-2  "></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item " style="background-image: url('{{asset('assets/images/banner1.jpg')}}') ;">
                <div class="hero-background-overlay"></div>
                <div class="container h-100">
                    <div class="row align-items-center d-flex h-100">
                        <div class="col-md-7">
                            <div class="block" >
                                <h1 class="mb-3 mt-3">Explore Our Services and Dive Into Engaging Blogs on Our Laravel Web App!</h1>
                                <p class="mb-4 pr-5">Dive into our FAQs section to find quick answers and solutions. Your common queries addressed for a seamless experience.</p>
                                <div class="btn-container ">
                                    <a href="{{ url('/contact') }}" class="btn btn-primary">Contact Now <i class="icofont-simple-right ml-2  "></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="carousel-item" style="background-image: url('{{asset('assets/images/banner24.jpg')}}') ;">
                <div class="hero-background-overlay"></div>
                <div class="container align-items-center d-flex h-100">
                    <div class="container h-100">
                        <div class="row align-items-center d-flex h-100">
                            <div  class="col-md-7">
                                <div class="block" >
                                    <div class="divider mb-3"></div>
                                    <span class="text-uppercase text-sm letter-spacing">Stephen R. Covey</span>
                                    <h1 class="mb-3 mt-3">The key is in not spending time, but in investing it.</h1>

                                    <p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p>
                                    <div class="btn-container ">
                                        <a href="{{ url('/contact') }}" class="btn btn-primary">Contact Now <i class="icofont-simple-right ml-2  "></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<section class="section-2  py-5">
    <div class="container py-2">
        <div class="row">
            <div class="col-md-6 align-items-center d-flex">
                <div class="about-block">
                    <h1 class="title-color">Welcome</h1>
                    <div class="mt-2 mb-3 text-muted">Professionals &amp; Creative People</div>
                    <p>Welcome to our website! Explore insightful blogs, discover specialized services, get quick answers from FAQs, reach out via "Contact Us," learn about us in the "About Us" section, and enjoy a seamless experience of information and interaction all in one place. Whether you're seeking knowledge, solutions, or connection, we've got you covered.</p>
                    <p>We've seamlessly blended education, convenience, and human connection into this digital haven. Whether you're here to broaden your horizons, solve challenges, or simply engage, our website is designed to make your experience transformative and fulfilling. Welcome to an online journey like no other!
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="image-red-background">
                    <img src="{{asset('assets/images/about-us.jpg')}}" alt="" class="w-100">
                </div>

            </div>
        </div>
    </div>
</section>

<section class="section-3 py-5">
    <div class="container">
        <h2 class="title-color mb-4 h1">Services
            <div class="divider mb-3"></div>

        </h2>
        <div class="cards">
            <div class="services-slider">

                @if(!empty($services))
                @foreach ($services as $service)

                <div class="card border-0 ">
                    <a href="{{ url('/services/detail/'.$service->id) }}">
                    @if(!empty($service->image))
                        <img src="{{asset('uploads/temp/services/thumb/small/'.$service->image)}}" class="card-img-top" alt="">
                        @else
                        <img src="{{ asset('uploads/temp/placeholder.jpg') }}" height="180px" alt="">
                        @endif
                    </a>
                    <div class="card-body p-3">
                        <h1 class="card-title mt-2"><a href="{{ url('/services/detail/'.$service->id) }}">{{ $service->name }}</a></h1>
                        <div class="content pt-2">
                            <p class="card-text">{{ $service->short_desc }}</p>
                        </div>
                        <a href="{{ url('/services/detail/'.$service->id) }}" class="btn btn-primary mt-4">Details <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
        </div>
    </div>
</section>

    {{-- include need help banner --}}
    @include('common.need-banner')
    {{-- including need help banner --}}


    {{-- include common blog file --}}
        @include('common.latest-blog')
    {{-- include common blog file --}}

@endsection
