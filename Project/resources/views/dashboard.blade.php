@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="title m-b-md">
                    WELCOME<br>
                    <?php
                        $id= Auth::id();
                        
                        $name= DB::table('users')->
                            where('id',$id)->value('username');
                        
                        echo $name
                    ?>
                </div>

                <div class="links">
                    <a href="https://github.com/3daniele/SviluppoAgile3">GitHub</a>
                </div>
        </div>
    </div>
</div>
@endsection
