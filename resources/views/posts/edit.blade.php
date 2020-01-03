@extends('layouts.base')

@section('content')
    {!! Form::open(['action'=>['PostsController@update', $post->id], 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $post->title, ['class'=>'form-control', 'placeholder'=>'Enter the title'])}}
        </div>
        <div class="form-group">
            {{Form::label('cover_image', 'Pick up the cover image')}}
            {{Form::file('cover_image', ['class'=>'form-control-file', 'accept'=>'image/*'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', $post->body, ['class'=>'form-control', 'placeholder'=>'Enter the blog text', 'id'=>'summary-ckeditor'])}}
        </div>
        {{Form::submit('Update', ['class'=>'btn btn-outline-dark'])}}
    {!! Form::close() !!}    
@endsection