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
                    <span class="d-none" id="token">{{Auth::user()->stoken}}</span>
                    </br>
                    </br>
                    <button type="button" class="btn btn-primary" id="play">Riproduci</button>
                </div>
        </div>
    </div>
</div>
<script src="https://sdk.scdn.co/spotify-player.js" defer></script>
<script src="/js/playerhost.js"></script>
@endsection