@extends('layouts.app')

@section('content')
<a href="/listings" class="btn btn-outline-primary mb-2">Go back</a>
<h1 id="show-address" class="text-center">{{$listing->address}}</h1>
<img class="rounded mx-auto d-block" src="/storage/images/{{$listing->image}}">

{{-- Insert listing data into elements --}}
<div class="d-flex flex-row flex-wrap justify-content-between">
    <div class="mt-3 show-details">
        <h5>Details</h5>
        <p>{{$listing->type}} |
            Size <b>{{$listing->size}}</b> m² |
            Bedrooms <b>{{$listing->bedrooms}}</b>
            <i class="fas fa-bed text-muted mx-1"></i> |
            Bathrooms <b>{{$listing->bathrooms}}</b>
            <i class="fas fa-bath text-muted mx-1"></i>
            <br>Address: {{$listing->address}}
        </p>
        <div class="pr-2">
            <h5 class="mt-3">Description</h5>
            <p>{!! $listing->desc !!}</p>
        </div>

    </div>
    <div class="mt-3">
        <h5>Location on map</h5>
       {{-- Leaflet map --}}
        <div id="map">
            <input type="hidden" id="lng" value="{{$listing->longtitude}}">
            <input type="hidden" id="lat" value="{{$listing->latitude}}">
        </div>
    </div>
</div>


<hr>
<small>Created {{$listing->created_at}} by {{$listing->user->name}}</small>
<hr>
{{-- Show edit and delete buttons if you're logged in and you've created the listing --}}
@if (!Auth::guest())
@if (Auth::user()->id == $listing->user_id)

<div class="flex-vertical d-flex justify-content-start mb-3">
    <a href="/listings/{{$listing->id}}/edit" class="btn btn-outline-primary mr-2">Edit</a>
    {!!Form::open(['action' => ['ListingsController@destroy', $listing->id], 'method' => 'POST', 'class' =>
    'pull-right'])!!}
    
    {{-- Use DELETE method instead of POST --}}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
</div>
{!!Form::close() !!}
@endif
@endif
@endsection
