<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Suggest;
use App\Music;
use App\Like;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addMusic(Request $request, $id) {

        if (!(Music::where('uri', $request->uri)->exists())) {
            $music = new Music;
            $music->uri = $request->uri;
            $music->artists = $request->artists;
            $music->name = $request->name;
            $music->duration = $request->duration;
            $music->save();
        }
    
        
        /*
        $hosting = Hosting::where('id', $id)->first();
        $user = Auth::user()->id;

        if ($hosting->user == $user) {

        }
        else {
            return redirect('/dashboard')->with('error','Non è il tuo party!');
        }
        */
    }

    public function suggestMusic(Request $request, $id){
        /*
        if (!(Music::where('music_id', $request->uri)->exists())) {
            $music = new Music;
            $music->uri = $request->uri;
            $music->artists = $request->artists;
            $music->name = $request->name;
            $music->duration = $request->duration;
            $music->save();
        }
        */

        $user=Auth::user()->id;
        echo $user;

        if(!(Suggest::where([['music_id', $request->uri],['hosting_id',$id]])->exists())){
            $suggest=new Suggest;
            $suggest->hosting_id=$id;
            $suggest->user_id=$user;
            $suggest->music_id=$request->uri;
            $suggest->created_at=Carbon::now()->toDateTimeString();
            $suggest->updated_at=Carbon::now()->toDateTimeString();
            $suggest->save();
        }
    }

    public function addLike(Request $request, $id) {

        $user = Auth::user()->id;

        if (!(Like::where([['music_id', $request->music],['user_id', $user]])->exists())) {
            $like = new Like;
            $like->user_id = $user;
            $like->playlist_id = $request->playlist;
            $like->created_at=Carbon::now()->toDateTimeString();
            $like->updated_at=Carbon::now()->toDateTimeString();
            $like->save(); 

            $votes = Playlist::where('id', $request->playlist)->first();
            $votes->votes = $votes->votes + 1;
            $votes->save();
        }
    } 
}
