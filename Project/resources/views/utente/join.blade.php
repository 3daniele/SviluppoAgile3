@extends('layouts.app')

@section('content')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Enter!</h1>
  <div>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('enter.store') }}">
          @csrf

          <div class="form-group">
              <input type="text" class="form-control" name="url" placeholder="paste here your url"></input>
          </div>
          
                                 
          <button type="submit" class="btn btn-outline-primary">Enter</button>
      </form>
  </div>
</div>
</div>
@endsection