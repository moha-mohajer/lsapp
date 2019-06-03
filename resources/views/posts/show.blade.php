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

  {!!Form::open(['action'=>['PostsController@destroy', $post->id],'method'=>'POST', 'class' =>"pull-right"])!!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
  {!!Form::close()!!}
@endsection