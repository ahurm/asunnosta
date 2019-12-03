@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="dashboard-flex">
                        <h3>Your Listings</h3>
                        <a href="/listings/create" class="btn btn-primary position-relative fixed-right">Create
                            Listing</a>
                    </div>
                    <table class="table table-striped">
                        @if (count($listings) > 0)
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($listings as $listing)
                                <tr>
                                    <th class="dashboard-listing align-middle"><a href="/listings/{{$listing->id}}">{{$listing->type}}, {{$listing->address}}</a></th>
                                    <th><a href="/listings/{{$listing->id}}/edit" class="btn btn-outline-primary">Edit</th>
                                    <th> {!!Form::open(['action' => ['ListingsController@destroy', $listing->id], 'method' =>
                                        'POST', 'class' => 'pull-right'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close() !!}
                                    </th>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th>No listings found</th>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection