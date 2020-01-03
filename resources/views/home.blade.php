@extends('layouts.base')

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

                    <h4>Welcome {{$user->name}}!</h4>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Got something on mind</div>
            <div class="card-body">
                <a href="posts/create" class="btn btn-outline-dark w-100"> Create Posts</a>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Posts</div>
                <div class="card-body">
                    @if (count($user->posts) > 0)
                        @foreach ($user->posts as $post)
                            <div class="card card-body bg-light">           
                                <h3><a href="posts/{{$post->id}}">{{$post->title}}</a></h3>
                                <small>Posted at {{$post->created_at}} written by {{$post->user->name}}</small>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
