@extends('layouts.app')

@section('content')
<div class="row">
 <div class="col-sm-8 offset-sm-2">
    <h1 class="display-3">Create a new Party</h1>
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
      <form method="post" action="{{ route('hosting.store') }}">
          @csrf

          <div class="form-group">
              <label for="Utente">Id utente:</label>
              <input type="text" class="form-control" name="user_id">
          </div>
          <div class="form-group">
              <label for="NParty">Party Name</label>
              <input type="text" class="form-control" name="name">
          </div>
          <div class="form-group">
              <label for="SceltaGenere">Select genre</label>
                <select class="form-control" name="genre">
                   <option id="1" value="1">Rock</option>
            </select>
          </div>
          <div class="form-group">
              <label>Mod</label>
              <input type="text" class="form-control" name="mod"/>
          </div>
          <div class="form-group">
              <label>Type:</label>
                <select class="form-control" name="type">
                    <option value="Democracy">Democracy</option>
                    <option value="Battle">Battle</option>
                </select>
          </div>
          <div class="form-group">
              <label>Visibility:</label>
                <select class="form-control" name="open">
                   <option id="yes" value="yes">Open</option>
                   <option id="no" value="no">Closed</option>
            </select>
          </div>
                                 
          <button type="submit" class="btn btn-primary-outline">Create</button>
      </form>
  </div>
</div>
</div>
@endsection