@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="title m-b-md">
                    WELCOME in <br>
                    <?php
                        $name= DB::table('Hostings')->
                            where('id',$hosting->id)->value('name');
                        
                        echo $name
                    ?>
                </div>
        </div>
    </div>
</div>
@endsection