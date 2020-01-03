@extends('layouts.base')

@section('content')
    <a href="/posts" class="btn btn-outline-dark" role="button">Go Back</a>
    @if (!Auth::guest())
        @if (Auth::user()->id == $post->user->id)
            {!! Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'delete', 'class'=>'float-right', 'style'=>'margin-left:4px']) !!}
                {{Form::submit('Delete', ['class'=>'btn btn-outline-danger'])}}
            {!! Form::close() !!}
            <a href="/posts/{{$post->id}}/edit" class="btn btn-outline-dark float-right">Edit</a>
        @endif
    @endif
    <br><br>
    <h1>{{$post->title}}</h1>
    @if ($post->cover_image!="noImage.png")
        <img src="/storage/cover_images/{{$post->cover_image}}" alt="Cover Image" style="width:100%">
    @endif
    <p>{!! $post->body !!}</p>
    <hr>
    <small>Posted at {{$post->created_at}} written by {{$post->user->name}}</small>
@endsection