@extends('layouts.app')

@section('content')
<section class="hero-small">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{asset('assets/images/banner1.jpg')}}') ;">
                <div class="hero-background-overlay"></div>
                <div class="container  h-100">
                    <div class="row align-items-center d-flex h-100">
                        <div class="col-md-12">
                            <div class="block text-center">
                                <span class="text-uppercase text-sm letter-spacing"></span>
                                <h1 class="mb-3 mt-3 text-center">{{ $service->name }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-2  py-5">
    <div class="container py-2">
        <div class="row">
            <div class="col-md-6 align-items-center d-flex">
                <div class="about-block">
                    <h1 class="title-color">{{ $service->name }}</h1>
                    <p> {!! $service->description !!}</p>

                </div>
            </div>
            <div class="col-md-6">
                @if(!empty($service->image))
                <div class="image-red-background">
                    <img src="{{ asset('uploads/temp/services/thumb/large/'.$service->image) }}" class="w-100" alt="">
                </div>
                @else
                    <img src="{{ asset('uploads/temp/placeholder.jpg') }}"alt="" class="w-100">
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
