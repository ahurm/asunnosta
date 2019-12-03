@extends('layouts.app')

@section('content')
<h1>Create Listing</h1>
{!! Form::open(['action' => 'ListingsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="form-group">
    <div class="flex-inputs">
        <div class="price">
            {{Form::label('typeLabel', 'Apartment type')}}
            <div class="price-inputs">
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
                {{Form::number('bedrooms', '', ['min' => '0', 'class' => 'form-control', 'placeholder' => '#'])}}
            </div>
        </div>
        <div class="bathrooms">
            {{Form::label('bathroomsLabel', 'Bathrooms')}}
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
                {{Form::text('price', '', ['class' => 'form-control', 'placeholder' => 'Price'])}}
                <p>€</p>
            </div>
        </div>
        <div class="size">
            {{Form::label('sizeLabel', 'Size')}}
            <div class="size-inputs">
                {{Form::text('size', '', ['class' => 'form-control', 'placeholder' => 'Size'])}}
                <p>m²</p>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    {{Form::label('addressLabel', 'Address')}}
    {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address'])}}
</div>
<div class="form-group">
    {{Form::label('descLabel', 'Description')}}
    {{Form::textarea('desc', '', ['id' => 'editor','class' => 'form-control', 'placeholder' => 'Description'])}}
</div>
<div class="form-group">
    {{Form::file('image')}}
</div>
{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}
@endsection