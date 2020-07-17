@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">History Party</h1>    
      <table class="table table-striped">
        <thead>
            <tr>
              <td>Number</td>
              <td>Date</td>
              <td>Name</td>
              <td>Type</td>
              <td colspan = 2>Actions</td>
            </tr>
        </thead>
        <tbody>
                <?php
                    $count=1;    
                ?>
            @foreach($h as $a)

            <tr>
                <td><?php
                        echo $count;    
                    ?></td>
                <td>{{$a->create_time}}</td>
                <td>{{$a->name}}</td>
                <td>{{$a->type}}</td>
                <td>
                    <a href="{{ route('hosting.show',$a->id)}}" class="btn btn-primary">View</a>
                </td>
                <td>
                    <a href="{{ route('hosting.edit',$a->id)}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form action="{{ route('hosting.delete',$a->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php
                $count++;    
            ?>
            @endforeach
        </tbody>
      </table>


      <table class="table table-striped">
        <thead>
            <tr>
              <td>Number</td>
              <td>Name</td>
              <td>Status</td>
              <td colspan = 2>Actions</td>
            </tr>
        </thead>
        <tbody>
                <?php
                    $count=1;    
                ?>            
            @foreach($p as $a)
            <tr>
                <td><?php
                        echo $count;    
                    ?></td>
                <td>{{\App\Hosting::where('id', $a->hosting_id)->value('name')}}</td>
                <td>{{$a->status}}</td>
                <td>
                    <a href="{{ route('user.show',$a->hosting_id)}}" class="btn btn-primary">View</a>
                </td>
            </tr>
            <?php
                $count++;    
            ?>
            @endforeach
        </tbody>
      </table>
    <div>
    </div>
    @endsection