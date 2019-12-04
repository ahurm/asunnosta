@extends('layouts.app')

@section('content')
<h1>Create Listing</h1>

{{-- Form --}}
{!! Form::open(['action' => 'ListingsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="form-group">
    <div class="flex-inputs">
        <div class="price">
            {{Form::label('typeLabel', 'Apartment type')}}
            <div class="price-inputs">
            
            {{-- Dropdown --}}
                {{Form::select('type', [
                            'Apartments' => 'Apartments', 
                            'Detached house' => 'Detached house',
                            'Duplex' => 'Duplex',
                            'Rowhouse' => 'Rowhouse'
                            ], null, ['placeholder' => 'Choose type...', 'class' => 'form-control'])}}
            </div>
        </div>
        <div class="bedrooms">
            {{Form::label('bedroomsLabel', 'Bedrooms')}}
            <div class="bedrooms-inputs">
            
            {{-- Number input --}}
                {{Form::number('bedrooms', '', ['min' => '0', 'class' => 'form-control', 'placeholder' => '#'])}}
            </div>
        </div>
        <div class="bathrooms">
            {{Form::label('bathroomsLabel', 'Bathrooms')}}
            
            {{-- Number input --}}
            <div class="bathrooms-inputs">
                {{Form::number('bathrooms', '', ['min' => '0', 'class' => 'form-control', 'placeholder' => '#'])}}
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
                {{Form::text('price', '', ['class' => 'form-control', 'placeholder' => 'Price'])}}
                <p>€</p>
            </div>
        </div>
        <div class="size">
            {{Form::label('sizeLabel', 'Size')}}
            <div class="size-inputs">
            
            {{-- Text input --}}
                {{Form::text('size', '', ['class' => 'form-control', 'placeholder' => 'Size'])}}
                <p>m²</p>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    {{Form::label('addressLabel', 'Address')}}
    
    {{-- Text input --}}
    {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
</div>
<div class="form-group">
    {{Form::label('descLabel', 'Description')}}
    
    {{-- Text input with CKEditor 5 --}}
    {{Form::textarea('desc', '', ['id' => 'editor','class' => 'form-control', 'placeholder' => 'Description'])}}
</div>
<div class="form-group">

{{-- Image upload --}}
    {{Form::file('image')}}
</div>

{{-- Submit button --}}
{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}
@endsection
