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
            //console.log(data);
            var time = data.data.progress_ms;
            //console.log(time);

            //riproduzione
            var battle = JSON.parse($("#battle").text());
            console.log(battle);

            var uris = new Array(2);
            uris[0] = battle.uri1;
            uris[1] = battle.uri2;
            
            console.log(uris);
            
            var indice = 0;
            for (i in uris) {
                if (uris[i] == current) {
                    indice = i;
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


    function millisToMinutesAndSeconds(millis) {
        var minutes = Math.floor(millis / 60000);
        var seconds = ((millis % 60000) / 1000).toFixed(0);
        return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
    }


    /*----------------------- VOTAZIONE DI UNA CANZONE --------------------*/  
    $(document).on("click", "#vote", function (event) {
        event.preventDefault();
        var vote = $(this).val();
        console.log(vote);
        
        $.ajax({
            url: `/hosting/${hosting_id}/battle/vote`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'vote': vote
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
