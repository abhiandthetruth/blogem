@extends('layouts.base')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach ($posts as $post)
        <div class="card card-body">
            <div class='row'>
                <div class="col-md-4 col-sm-4">
                    <img src="storage/cover_images/{{$post->cover_image}}" alt="Cover Image" style="width:100%">
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3><a href="posts/{{$post->id}}">{{$post->title}}</a></h3>
                    <small>Posted at {{$post->created_at}} written by {{$post->user->name}}</small>
                </div>
            </div>
        </div>

        @endforeach
        <hr>
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection