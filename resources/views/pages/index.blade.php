@extends('layouts.app')

@section('content')
  <div class="jumbotron text-center">
    {{-- <h1>{{$title}}</h1> --}}
    <h1><?php echo $title; ?></h1>
    <p>This is first app created by Moha in Laravel</p>
    <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
  </div>
@endsection
