@extends('layouts.app')

@section('content')
    <h1>Listings</h1>
    @if (count($listings) > 0)
        @foreach ($listings as $listing)
        <div class="card card-body bg-light">
            <div class="d-flex flex-xl-row flex-lg-row justify-content-xl-start justify-content-lg-start">
                <div class="house-img-container">
                    <img class="house-img" src="/storage/images/{{$listing->image}}">
                </div>
                <div class="
                d-flex 
                flex-xl-row 
                flex-lg-row 
                flex-md-column 
                flex-sm-column
                flex-column
                justify-content-xl-between 
                justify-content-lg-between 
                justify-content-md-between
                justify-content-sm-between
                justify-content-between
                flex-xl-fill 
                flex-lg-fill
                flex-md-fill
                flex-sm-fill
                flex-fill
                ">
                    <div class="house-info">
                        <h4><a href="/listings/{{$listing->id}}">{{$listing->title}}</a></h4>
                        <p>{{$listing->address}}</p>
                        <div class="
                        d-none
                        d-md-none
                        d-sm-none
                        d-xs-none 
                        d-lg-block
                        d-xl-block
                        ">{!!$listing->body!!}</div>
                    </div>
                    <div class="
                    house-price 
                    align-self-xl-center
                    align-self-lg-center
                    align-self-md-start
                    align-self-sm-start
                    align-self-start
                    ">
                        <h5>{{$listing->price}} €</h5>
                    </div>   
                </div>

            </div>
        </div>
        @endforeach
    @else
        <p>No listings found</p>
    @endif
@endsection




<h1>Listings</h1>
    @if (count($listings) > 0)
    @foreach ($listings as $listing)
    <div class="card card-body bg-light">
        <div class="d-flex flex-xl-row flex-lg-row justify-content-xl-start justify-content-lg-start">
            <div class="house-img-container">
                <img class="house-img" src="/storage/images/{{$listing->image}}">
            </div>
            <div class="
                d-flex 
                flex-xl-row 
                flex-lg-row 
                flex-md-column 
                flex-sm-column
                flex-column
                justify-content-xl-between 
                justify-content-lg-between 
                justify-content-md-between
                justify-content-sm-between
                justify-content-between
                flex-xl-fill 
                flex-lg-fill
                flex-md-fill
                flex-sm-fill
                flex-fill
                ">
                <div class="house-info">
                    <h4><a href="/listings/{{$listing->id}}">{{$listing->type}}, {{$listing->bedrooms}}bd, {{$listing->bathrooms}}ba, {{$listing->size}}m2</a></h4>
                    <p>{{$listing->address}}</p>
                    <div class="
                        d-none
                        d-md-none
                        d-sm-none
                        d-xs-none 
                        d-lg-block
                        d-xl-block
                        ">{!!$listing->desc!!}</div>
                </div>
                <div class="
                    house-price 
                    align-self-xl-center
                    align-self-lg-center
                    align-self-md-start
                    align-self-sm-start
                    align-self-start
                    ">
                    <h5>{{$listing->price}} €</h5>
                </div>
            </div>

        </div>
    </div>
    @endforeach
    @else
    <p>No listings found</p>
    @endif
    @endsection