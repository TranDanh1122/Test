@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Category') }}</div>

                <div class="card-body">
                    <h1>{{$category->category_name}}</h1>
                    <p>{{$category->description}}
                    <p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection