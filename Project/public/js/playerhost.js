window.onSpotifyWebPlaybackSDKReady = () => {
    
    const hosting_id = $("#hosting_id").text();
    // console.log(hosting_id);

    const token = $("#token").text();
    // console.log(token);
    
    const player = new Spotify.Player({
      name: 'Web Playback SDK Quick Start Player',
      getOAuthToken: cb => { cb(token); }
    });
    var deviceId;
  
    
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
    });
  
    // Not Ready
    player.addListener('not_ready', ({ device_id }) => {
      console.log('Device ID has gone offline', device_id);
    });
  
    // Connect to the player!
    player.connect();


    function millisToMinutesAndSeconds(millis) {
        var minutes = Math.floor(millis / 60000);
        var seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
    }



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
                        let img = item.children('div').children('div').first().find('img');
                        img.attr('src', element.album.images[0].url);

                        let content = item.children('div').children('div').last();
                        content.children('div').first().find('h6').text(element.name);
                        content.children('div').first().find('small').text(millisToMinutesAndSeconds(element.duration_ms));

                        let artists = "";
                        $.each(element.artists, function (index, artist) {
                            artists += artist.name + ' ';
                        });

                        content.children('div').last().children().first().text(artists);
                        content.children('div').last().children().last().text(element.album.name)

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



    /*----------------------- AGGIUNTA DI UNA CANZONE ALLA PLAYLIST --------------------*/
    $(document).on("click", ".item", function (event) {
        event.preventDefault();
        console.log(this);
        let track_uri = $(this).data('uri');
        // console.log(track_uri);
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
        })

        $.ajax({
            url: `/hosting/${hosting_id}/playlist`,
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
        })
    })


    /*-----------------------------Asdrubale--------------------------------- */
    
    /*----------------------- RIPRODUZIONE DI UNA PLAYLIST --------------------*/
    $("#play").click(function (event) {
        event.preventDefault();
        
        var playlist = JSON.parse($("#playlist").text());
        console.log(playlist);
    
        var uris = new Array();
    
        for (i in playlist) {
            // console.log(playlist[i].music_id);
            uris.push(playlist[i].music_id);
            console.log(uris[i]);
        }
        
        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
    
        instance({
            url: "https://api.spotify.com/v1/me/player/play?device_id=" + deviceId,
            method: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            data: {
                "uris": uris
            },
            dataType: 'json'
        }).then(function (data) {
        });
    });


    /*----------------------- RIPRESA DI UNA CANZONE --------------------*/
    $("#resume").click(function (event) {
        event.preventDefault();
        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
    
        instance({
            url: "https://api.spotify.com/v1/me/player/play?device_id=" + deviceId,
            method: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            data: {
            },
            dataType: 'json'
        }).then(function (data) {
        });
    });


    /*----------------------- PAUSA DI UNA CANZONE --------------------*/
    $("#pause").click(function (event) {
        event.preventDefault();
        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
    
        instance({
            url: "https://api.spotify.com/v1/me/player/pause?device_id=" + deviceId,
            method: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            dataType: 'json'
        }).then(function (data) {
        });
    });

    /*----------------------- PROSSIMA CANZONE --------------------*/
    $("#next").click(function (event) {
        event.preventDefault();
        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
    
        instance({
            url: "https://api.spotify.com/v1/me/player/next?device_id=" + deviceId,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            dataType: 'json'
        }).then(function (data) {
        });
    });
    
    /*----------------------- CANZONE PRECEDENTE --------------------*/
    $("#previous").click(function (event) {
        event.preventDefault();
        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
    
        instance({
            url: "https://api.spotify.com/v1/me/player/previous?device_id=" + deviceId,
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            dataType: 'json'
        }).then(function (data) {
        });
    });

    /*----------------------- CAMBIO DEL VOLUME --------------------*/
    $("#setVolume").on('input change', function (event) {
        event.preventDefault();
        
        var volume = document.getElementById("setVolume").value;
        console.log(volume);
        
        var instance = axios.create();
        delete instance.defaults.headers.common['X-CSRF-TOKEN'];
    
        instance({
            url: "    https://api.spotify.com/v1/me/player/volume?volume_percent=" + volume + "&device_id=" + deviceId,
            method: 'PUT',
            headers: {
                'Authorization': 'Bearer ' + token,
            },
            dataType: 'json'
        }).then(function (data) {
        });
    });
};
