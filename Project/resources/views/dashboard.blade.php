@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="title m-b-md">
                    WELCOME
                    <?php
                        $id= Auth::id();
                        
                        $name= DB::table('users')->
                            where('id',$id)->value('username');
                        
                        echo $name
                    ?>
                </div>
                </br>
                </br>
                
                 <!--Tabella party-->
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Date</th>
                      <th scope="col">Name</th>
                      <th scope="col">Genre</th>
                      <th scope="col">Type</th>
                      

                      <th scope="col"></th> 
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $count = 1;
                  ?>
                  @foreach(\App\Hosting::where([['open', 'yes'], ['online', 'yes']])->get() as $hosting)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $hosting->create_time }}</td>
                        <td>{{ $hosting->name }}</td>
                        <td>{{ \App\Genre::where('id', $hosting->genre_id)->value('name')}}</td>
                        <td>{{ $hosting->type }}</td>
                        
                        <td>
                          <button type="button" class="btn btn-primary" id="join" value="{{$hosting->url}}">Join</button>
                        </td>
                <?php
                    $count++;
                ?>
                  @endforeach
                    </tr> 
                </tbody>
        </div>
    </div>
</div>
<script src="/js/dashboard.js"></script>
@endsection
