{{-- find any errors --}}
@if(count($errors) > 0)
  @foreach($errors->all() as $error)
    <div class="alart alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif


@if(session('success'))
    <div class="alart alert-success">
      {{session('success')}}
    </div>
@endif

{{-- find sessions errors --}}
@if(session('error'))
    <div class="alart alert-danger">
      {{session('error')}}
    </div>
@endif

