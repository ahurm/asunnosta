@extends('layouts.app')

@section('content')

{{-- Form --}}
<form action="{{action('SearchController@search')}}" method="POST">
    {{csrf_field()}}
    <div class="form-group">
        <div class="flex-inputs">
            <div class="flex-vertical">
                <label>Apartment type</label>
                <div class="price-inputs">
                
                {{-- Multiselect dropdown --}}
                    <select id="apartment-type" name="types[]" multiple="multiple" class="form-control">
                        <option value="Apartments">Apartments</option>
                        <option value="Detached house">Detached house</option>
                        <option value="Duplex">Duplex</option>
                        <option value="Rowhouse">Rowhouse</option>
                    </select>
                </div>
                <div class="flex-items-second">
                    {{Form::label('priceLabel', 'Price')}}
                    <div class="price-inputs">
                    
                    {{-- Text input --}}
                        {{Form::text('priceMin', '', ['class' => ['form-control','short-input'], 'placeholder' => 'min'])}}
                        <p>-</p>
                        
                    {{-- Text input --}}
                        {{Form::text('priceMax', '', ['class' => ['form-control','short-input'], 'placeholder' => 'max'])}}
                        <p>€</p>
                    </div>
                </div>
            </div>
            <div class="flex-vertical">
                <label>Bedrooms</label>
                <div class="size-inputs">
                
                {{-- Multiselect dropdown --}}
                    <select id="room-amount" name="rooms[]" multiple="multiple" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">Over 4</option>
                    </select>
                </div>
                <div class="flex-items-second">
                    {{Form::label('sizeLabel', 'Size')}}
                    <div class="size-inputs">
                    
                    {{-- Text input --}}
                        {{Form::text('sizeMin', '', ['class' => ['form-control','short-input'], 'placeholder' => 'Size'])}}
                        <p>-</p>
                        
                    {{-- Text input --}}
                        {{Form::text('sizeMax', '', ['class' => ['form-control','short-input'], 'placeholder' => 'Size'])}}
                        <p>m²</p>
                    </div>
                </div>
            </div>
            <div class="flex-vertical d-flex justify-content-between">
                <div class="flex-vertical">
                    <label>Sort By</label>
                    
                    {{-- Multiselect dropdown --}}
                    <select id="sortby" name="sortby" class="form-control">
                        <option value="Recent">Recent</option>
                        <option value="Oldest">Oldest</option>
                        <option value="Price ascending">Price ascending</option>
                        <option value="Price descending">Price descending</option>
                        <option value="Size ascending">Size ascending</option>
                        <option value="Size descending">Size descending</option>
                    </select>
                </div>
                <input class="btn btn-primary search-button" type="submit" value="Search">
            </div>
        </div>
</form>
<h1>Listings</h1>
{{-- Loop through listings if they exists --}}
@if (count($listings) > 0)
@foreach ($listings as $listing)

{{-- Add three listings per deck --}}
@if ($loop->index % 3 == 0 || $loop->first)
@php
$i = 0;
@endphp
<div class="card-deck">
    @endif

{{-- Insert listing data into elements --}}
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


    @php
    $i = $i + 1;
    @endphp
    @if ($loop->last || $i == 3)
</div>
@endif

@endforeach
@else
<p>No listings found</p>
@endif

@endsection
