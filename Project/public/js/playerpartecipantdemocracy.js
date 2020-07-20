window.onSpotifyWebPlaybackSDKReady = () => {
    
    const hosting_id = $("#hosting_id").text();
    // console.log(hosting_id);
    const token = $("#token").text();
    console.log(token);
    
    const player = new Spotify.Player({
      name: 'Web Playback SDK Quick Start Player',
      getOAuthToken: cb => { cb(token); }
    });
    var deviceId;

    function millisToMinutesAndSeconds(millis) {
        var minutes = Math.floor(millis / 60000);
        var seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
    }
  
    
    // Error handling
    player.addListener('initialization_error', ({ message }) => { console.error(message); });
    player.addListener('authentication_error', ({ message }) => { console.error(message); });
    player.addListener('account_error', ({ message }) => { console.error(message); });
    player.addListener('playback_error', ({ message }) => { console.error(message); });
  
    // Playback status updates
    player.addListener('player_state_changed', state => { console.log(state); });
    
    // Ready
    player.addListener('ready', ({ device_id }) => {
      console.log('Ready with Device ID', device_id);
      deviceId = device_id;
      
    /*----------------------- BRANO IN RIPRODUZIONE --------------------*/
    var pippo = $("#htoken").text();
    console.log(pippo);

    var instance = axios.create();
    delete instance.defaults.headers.common['X-CSRF-TOKEN'];
     
    instance({
        url: "https://api.spotify.com/v1/me/player/currently-playing",
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + pippo,
        },
        dataType: 'json'
    }).then(function (data) {
        var current = data.data.item.uri;//uri corrente
        console.log(data);
        var time= data.data.progress_ms;
        console.log(time);

        //riproduzione
        var playlist = JSON.parse($("#playlist").text());
        //console.log(playlist);
    
        var uris = new Array();
    
        for (i in playlist) {
            // console.log(playlist[i].music_id);
            uris.push(playlist[i].music_id);
            //console.log(uris[i]);
        }
        console.log(uris);
        var indice=0;
        for(i in uris){
            if(uris[i]==current){
                indice=i;
            }
        }
        console.log(indice);
        //SELECT stoken FROM users,hostings,enters WHERE (users.id=enters.user_id && hostings.id=enters.hosting_id && enters.status="online");
        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
    
        instance({
            url: "https://api.spotify.com/v1/me/player/play?device_id=" + deviceId,
            method: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            data: {
                "uris": uris,
                "offset": {
                    "position": indice
                },
                "position_ms": time
            },
            dataType: 'json'
        }).then(function (data) {
            instance({
                url: "https://api.spotify.com/v1/me/player/currently-playing",
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                dataType: 'json'
            }).then(function (data) {
                var current = data.data.item.uri;
                //console.log(current);
                var musics = JSON.parse($("#musics").text());
                //console.log(musics);
                for (i in musics) {
                    //console.log(music[i]);
                    if (current == musics[i].music_id) {
                        //$("<td class="+"now"+">now playing</td>").appendTo( "."+musics[i].id );
                        $("#now").text("");
                        $("#now").removeAttr("id");
                        $("."+musics[i].id).text("now playing");
                        $("."+musics[i].id).attr("id", "now");
                    }
                }           
            });
        })
    });
    

    });
  
    // Not Ready
    player.addListener('not_ready', ({ device_id }) => {
      console.log('Device ID has gone offline', device_id);
    });
  
    // Connect to the player!
    player.connect();


    /*----------------------- CERCARE UNA CANZONE --------------------*/
    $('#searchSong').on('keyup', function (e) {

        var song_name = $('#searchSong').val();
        // console.log(song_name);
        song_name = encodeURIComponent(song_name.trim());
        // console.log(song_name);
        var result = $('#result');

        if (song_name.length == 0) {
            result.fadeOut("normal", function () {
                result.empty();
            });
        }

        if (song_name.length > 0) {

            var instance = axios.create();
            delete instance.defaults.headers.common['X-CSRF-TOKEN'];

            instance({
                url: `https://api.spotify.com/v1/search?q=${song_name}&type=track,artist&limit=5`,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                dataType: 'json',
            })
                .then(function (data) {
                    result.empty();
                    let tracks = data.data.tracks.items;

                    $.each(tracks, function (index, element) {

                        let item = $('#song-prototype').clone();
                        let content = item.children('div').children('div').last();
                        let img = item.children('div').children('div').first().find('img');
                        img.attr('src', element.album.images[0].url);
                        img.attr('width',"100");

                        
                        content.children('div').first().find('h6').text(element.name);
                        content.children('div').first().find('small').text(millisToMinutesAndSeconds(element.duration_ms));

                        let artists = "";
                        $.each(element.artists, function (index, artist) {
                            artists += artist.name + ' ';
                        });

                        content.children('div').last().children().first().text(artists);
                        content.children('div').last().children().last().text(element.album.name);

                        item.attr('data-id', element.id);
                        item.attr('data-uri', element.uri);
                        item.attr('data-artists', artists);
                        item.attr('data-name', element.name);
                        item.attr('data-duration', millisToMinutesAndSeconds(element.duration_ms));
                        item.attr('data-number', index);
                        item.addClass('item');
                        item.removeAttr('id');
                        result.append(item).hide().fadeIn();
                    });

                })
                .catch(function (error) {
                    console.log(error, 'search error');
                })
        }
    })

    $('#searchSong').on('change', (e) => {
        $('#result').fadeOut("normal");
    });

    /*----------------------- SUGGERIMENTO DI UNA CANZONE ALLA PLAYLIST --------------------*/
    $(document).on("click", ".item", function (event) {
        event.preventDefault();
        //console.log(this);
        let track_uri = $(this).data('uri');
        //console.log(track_uri);
        let artists = $(this).data('artists');
        let name = $(this).data('name');
        let duration = $(this).data('duration');

        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
        
        $.ajax({
            url: `/hosting/${hosting_id}/musics`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'uri': track_uri,
                'artists' : artists,
                'name': name,
                'duration': duration
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error, 'error on item to add');
            }
        });

        $.ajax({
            //hosting/{id}/suggest
            url: `/hosting/${hosting_id}/suggest`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'uri': track_uri
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error, 'error on item to add');
            }
        });
    });

    /*----------------------- INSERIMENTO DI UN LIKE AD UNA CANZONE DELLA PLAYLIST --------------------*/  
    //hosting id e l'id della playlist  memorizziamo in like
    //var playlist = JSON.parse($("#playlists").text());
    //console.log(playlist); 
    $(document).on("click", "#like", function (event) {
        event.preventDefault();
        var playlist = $(this).val();
        console.log(playlist);

        $.ajax({
            //hosting/{id}/suggest
            url: `/hosting/${hosting_id}/like`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'playlist': playlist
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error, 'error on item to add');
            }
        });
        $(this).prop('disabled', true);
    });     
};
