@extends('layouts.app')

@section('content')
  <h1>{{$post->title}}</h1>
  <div>
    {!!$post->body!!}
  </div>
  <h1>
  <small>Writen on {{$post->created_at}}</small>
  <br><p><a href="/posts" class="btn btn-defult">Go Back</a></p>
@endsection