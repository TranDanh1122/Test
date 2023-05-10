@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post') }}</div>

                <div class="card-body">
                    <h1>{{$post->title}}</h1>
                    <p>{{$post->content}}
                    <p>
                    <h2>Related Category</h2>
                    <ul>
                        @foreach($post->category as $cat)
                        <li>
                            <a href="{{route('category.show',[$cat->id])}}"> {{$cat->category_name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection