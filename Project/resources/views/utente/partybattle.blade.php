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

                <span class="d-none" id="token">{{Auth::user()->stoken}}</span>
            <span class="d-none" id="hosting_id">{{$hosting->id}}</span>
            <span class="d-none" id="battle">{{$battle}}</span>

        <!--Tabella playlist-->
        <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Artists Names</th>
                <th scope="col">Song Name</th>
                <th scope="col">Duration</th>
                <th scope="col">Vote</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
            <span class="d-none" id="musics">{{\App\Battle::where('hosting_id', $hosting->id)->get()}}<span>
                  <?php
                  
                    if ($battle) {
                      echo('<tr>');
                        $a=\App\Music::where('uri', $battle->uri1)->value('artists');
                        echo("<td>'$a'</td>");
                        $a=\App\Music::where('uri', $battle->uri1)->value('name');
                        echo("<td>'$a'</td>");
                        $a=\App\Music::where('uri', $battle->uri1)->value('duration');
                        echo("<td>'$a'</td>");
                        $a=\App\Battle::where('uri1', $battle->uri1)->value('votes1');
                        echo("<td>'$a'</td>");
                        echo("<td>");
                        echo("<button type=\"button\" class=\"btn btn-primary\" id=\"vote\" value=\"vote1\">Vote</button>");
                        echo("</td>");
                        echo("<td></td>");
                        
                        echo('</tr>');
                    echo('<tr>');
                        $a = \App\Music::where('uri', $battle->uri2)->value('artists');
                        echo("<td>'$a'</td>");
                        $a = \App\Music::where('uri', $battle->uri2)->value('name');
                        echo("<td>'$a'</td>");
                        $a = \App\Music::where('uri', $battle->uri2)->value('duration');
                        echo("<td>'$a'</td>");
                        $a=\App\Battle::where('uri2', $battle->uri2)->value('votes2');
                        echo("<td>'$a'</td>");
                        echo("<td>");
                        echo("<button type=\"button\" class=\"btn btn-primary\" id=\"vote\" value=\"vote2\">Vote</button>");
                        echo("</td>");
                        echo('<td></td>');
                      
                    echo('</tr>');
                    }
                  ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<script src="https://sdk.scdn.co/spotify-player.js" defer></script>
<script src="/js/playerpartecipantbattle.js"></script>
@endsection