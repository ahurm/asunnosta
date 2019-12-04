@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>Welcome to AsunnOSTA</h1>
    {{-- Show login and register button only for guests --}}
    @guest
    <p>AsunnOSTA is the best website to list your apartment for sale. Login and list it! </p>
    <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg"
            href="/register" role="button">Register</a></p>
    @endguest

    @if ($listings !== null)
    <h5>You recently viewed</h5>
    <div class="card-deck mx-5 justify-content-around  ">

        @foreach ($listings as $listing)

        {{-- Listing on frontpage --}}
        <div class="card card-listing">
            <a href="/listings/{{$listing->id}}">
                <img class="card-img-top" src="/storage/images/{{$listing->image}}" alt="Image">
                <div class="card-body">
                    <h5 class="card-title">
                        <b>{{$listing->price}} €</b>
                    </h5>
                    <p class="card-text">{{$listing->type}}
                        <br>
                        <b>{{$listing->size}}</b> m² |
                        <b>{{$listing->bedrooms}}</b>
                        <i class="fas fa-bed text-muted mx-1"></i> |
                        <b>{{$listing->bathrooms}}</b>
                        <i class="fas fa-bath text-muted mx-1"></i>
                        <br>{{$listing->address}}
                    </p>
                    <div class="fade-text">
                        <p class="card-text">{!!$listing->desc!!}</p>
                        <p class="fader"></p>
                    </div>
                    <p class="card-text"><small class="text-muted">
                            @if ($listing->updated_at <= $listing->created_at)
                                Created {{$listing->created_at}} by {{$listing->user->name}}
                                @else
                                Updated {{$listing->updated_at}} by {{$listing->user->name}}
                                @endif
                        </small></p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else

    @endif



    @endsection
