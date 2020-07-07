<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use SpotifyWebAPI\Session;
use App\User;

class SpotifyAuthController extends Controller
{
    public function login() {
        
        $session = new Session(
            '7fcc6347abec4fb1b2794cbacaa10f31',     //CLIENT_ID
            '120545f8470245a7b5aaa1a05edea541',     //CLIENT_SECRET 
            'http://127.0.0.1:8000/callback'        //REDIRECT_URI  
        );

        $options = [
            'scope' => [
                'user-read-playback-state',
                'streaming',
                'user-read-email',
                'user-modify-playback-state',
                'user-read-private',
                'playlist-modify-public',
                'user-library-modify',
                'user-top-read',
                'user-read-playback-position',
                'user-read-currently-playing',
                'playlist-read-private',
                'user-follow-read',
                'user-read-recently-played',
                'playlist-modify-private',                
                'user-follow-modify',
            ],
        ];
        
        header('Location: ' . $session->getAuthorizeUrl($options));
        die();

    }


    public function getAuthCode(Request $request) {
       
        $session = new Session(
            '7fcc6347abec4fb1b2794cbacaa10f31',     //CLIENT_ID
            '120545f8470245a7b5aaa1a05edea541',     //CLIENT_SECRET 
            'http://127.0.0.1:8000/callback'        //REDIRECT_URI  
        );
        
        // Request a access token using the code from Spotify
        $session->requestAccessToken($_GET['code']);
        
        $accessToken = $session->getAccessToken();
        
        // Store the access token somewhere. In a database for example.
        $user = Auth::user();
        $user->stoken = $accessToken;
        $user->save();

        return redirect(url()->previous());
    }

    public function logout() {
        $user=Auth::user();
        $user->stoken=null;
        $user->save();
        
        return redirect(url()->previous());
    }


}
