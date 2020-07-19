<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Hostinng;
use App\Battle;
use App\Vote;

class BattleController extends Controller
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
        if(Battle::where('hosting_id',$id)->exists()){
            $battle_id = Battle::where('hosting_id', $id)->value('id');
            $battle = Battle::find($battle_id);
            $battle->uri1 = $request->battle[0];
            $battle->uri2 = $request->battle[1];
            $battle->votes1 = 0;
            $battle->votes2 = 0;
            $battle->save();
        }
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

    public function add(Request $request,$id){
        if(!(Battle::where([['hosting_id',$id],['uri1',$request->battle[0]],['uri2',$request->battle[1]]])->exists())){
            $battle=new Battle;
            $battle->hosting_id=$id;
            $battle->uri1=$request->battle[0];
            $battle->uri2=$request->battle[1];
            $battle->save();
        } 
    }

    public function vote(Request $request, $id) {
        
        $user_id = Auth::user()->id;
        $battle_id = Battle::where('hosting_id', $id)->value('id'); 

        if (!(Vote::where([['battle_id', $battle_id], ['user_id', $user_id]])->exists())) {
            
            $vote = new Vote;
            $vote->battle_id = $battle_id;
            $vote->user_id = $user_id;
            if ($request->vote == "vote1") {
                $battle = Battle::where('id', $battle_id)->first();
                $battle->votes1 = $battle->votes1 + 1; 
                $battle->save();
                $song = "1";
            }
            else {
                $battle = Battle::where('id', $battle_id)->first();
                $battle->votes2 = $battle->votes2 + 1;
                $battle->save();
                $song = "2";
            }
            
            $vote->song = $song;
            $vote->save();
        }
    }
}
