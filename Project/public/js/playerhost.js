window.onSpotifyWebPlaybackSDKReady = () => {
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
    });
  
    // Not Ready
    player.addListener('not_ready', ({ device_id }) => {
      console.log('Device ID has gone offline', device_id);
    });
  
    // Connect to the player!
    player.connect();

    $("#play").click( function (event) {
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
                "uris": ['spotify:track:0D4GpOPInKiPxEfQMchu4p'],
                "offset": {
                    "uri": 'spotify:track:0D4GpOPInKiPxEfQMchu4p',
                },
                "position_ms": 0
            },
            dataType: 'json'
        }).then(function (data) {
        });
    });
};