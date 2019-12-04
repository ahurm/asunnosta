@extends('layouts.app')

@section('content')
<h1>Edit Listing</h1>

{{-- Form --}}
{!! Form::open(['action' => ['ListingsController@update', $listing->id], 'method' => 'POST', 'enctype' =>
'multipart/form-data']) !!}

<div class="form-group">
    <div class="flex-inputs">
        <div class="price">
        
        {{-- Dropdown --}}
            {{Form::label('typeLabel', 'Apartment type')}}
            <div class="price-inputs">
                {{Form::select('type', [
                                    'Apartment' => 'Apartment', 
                                    'Detached house' => 'Detached house',
                                    'Duplex' => 'Duplex',
                                    'Rowhouse' => 'Rowhouse'
                                    ], $listing->type, ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="bedrooms">
            {{Form::label('bedroomsLabel', 'Bedrooms')}}
            <div class="bedrooms-inputs">
            
            {{-- Number input --}}
                {{Form::number('bedrooms', $listing->bedrooms, ['min' => '0', 'class' => 'form-control', 'placeholder' => '#'])}}
            </div>
        </div>
        <div class="bathrooms">
            {{Form::label('bathroomsLabel', 'Bathrooms')}}
            <div class="bathrooms-inputs">
            
            {{-- Number input --}}
                {{Form::number('bathrooms', $listing->bathrooms, ['min' => '0', 'class' => 'form-control', 'placeholder' => '#'])}}
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="flex-inputs">
        <div class="price">
            {{Form::label('priceLabel', 'Price')}}
            <div class="price-inputs">
            
            {{-- Text input --}}
                {{Form::text('price', $listing->price, ['class' => 'form-control', 'placeholder' => 'Price'])}}
                <p>€</p>
            </div>
        </div>
        <div class="size">
            {{Form::label('sizeLabel', 'Size')}}
            <div class="size-inputs">
            
            {{-- Text input --}}
                {{Form::text('size', $listing->size, ['class' => 'form-control', 'placeholder' => 'Size'])}}
                <p>m²</p>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    {{Form::label('addressLabel', 'Address')}}
    
    {{-- Text input --}}
    {{Form::text('address', $listing->address, ['class' => 'form-control', 'placeholder' => 'Address'])}}
</div>
<div class="form-group">
    {{Form::label('descLabel', 'Description')}}
    
    {{-- Text input with CKEditor 5 --}}
    {{Form::textarea('desc', $listing->desc, ['id' => 'editor','class' => 'form-control', 'placeholder' => 'Description'])}}
</div>
<div class="form-group">

{{-- Upload image --}}
    {{Form::file('image')}}
</div>

{{-- Make method to PUT instead of POST --}}
{{Form::hidden('_method','PUT')}}
{{Form::submit('Save', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}
@endsection
