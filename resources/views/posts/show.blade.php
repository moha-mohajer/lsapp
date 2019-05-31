@extends('layouts.app')

@section('content')
  <br><p><a href="/posts" class="btn btn-defult">Go Back</a></p>
  <h1>{{$post->title}}</h1>
  <div>
    {!!$post->body!!}
  </div>
  <hr>
  <small>Writen on {{$post->created_at}}</small>
  <hr>
  <a href="/posts/{{$post->id}}/edit" class="btn btn-defult">Edit</a>
@endsection