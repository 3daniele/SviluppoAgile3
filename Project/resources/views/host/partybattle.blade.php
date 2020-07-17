@extends('layouts.app')

@section('content')
<script>
  function copy() {
    /* Get the text field */
    var copyText = document.getElementById("myInput");
  
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/
  
    /* Copy the text inside the text field */
    document.execCommand("copy");
  
    /* Alert the copied text */
    alert("Copied the text: " + copyText.value);
  }
  </script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="title m-b-md">
                WELCOME in:
                <?php
                    $name= DB::table('Hostings')->
                        where('id',$hosting->id)->value('name');                    
                        echo $name
                ?>
                <br>
                <input type="text" class="form-control" value="{{$hosting->url}}" id="myInput">
                <button class="btn btn-primary" onclick="copy()">Copy text</button>
                <span class="d-none" id="token">{{Auth::user()->stoken}}</span>
                <span class="d-none" id="hosting_id">{{$hosting->id}}</span>
                <span class="d-none" id="playlist">{{$playlist}}</span>

                <!-- Single Widget Area -->
                <div class="single-widget-area search-widget-area mb-1 mt-3">
                  <form action="" method="" autocomplete="off">
                    <input id="searchSong" type="search" name="search" class="form-control" placeholder="Search for a song to add to the playlist...">
                  </form>

                  <div class="d-none">
                    <div id="song-prototype" class="list-group-item list-group-item-action flex-column align-items-start p-0">
                      <div class="row align-items-center">
                        <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                          <img  src="" alt="">
                        </div>
                        <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">
                          <div class="d-flex w-100 justify-content-between">
                            <h6>Nome canzone</h6>
                            <small class="mr-1">2:23</small>
                          </div>
                          <div class="d-flex w-100 justify-content-between">
                            <small>Artista</small>
                            <small class="mr-1">album</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="result"></div>
                </div>

                <!--Tabella playlist-->
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">Artists Names</th>
                      <th scope="col">Song Name</th>
                      <th scope="col">Duration</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach(\App\Playlist::where('hosting_id', $hosting->id)->get() as $music)
                      <tr>
                        <td>{{ \App\Music::where('uri', $music->music_id)->value('artists') }}</td>
                        <td>{{ \App\Music::where('uri', $music->music_id)->value('name') }}</td>
                        <td>{{ \App\Music::where('uri', $music->music_id)->value('duration') }}</td>
                      </tr> 
                  @endforeach
                </tbody>
                </table>
                <button type="button" class="btn btn-primary" id="previous">Previous</button>
                <button type="button" class="btn btn-primary" id="play">Play</button>
                <button type="button" class="btn btn-primary" id="resume">Resume</button>
                <button type="button" class="btn btn-primary" id="pause">Pause</button>
                <button type="button" class="btn btn-primary" id="next">Next</button>
                <input type="range" min="0" max="100" value="100" class="slider" id="setVolume">
            </div>
        </div>
    </div>
</div>
<script src="https://sdk.scdn.co/spotify-player.js" defer></script>
<script src="/js/playerhost.js"></script>
@endsection