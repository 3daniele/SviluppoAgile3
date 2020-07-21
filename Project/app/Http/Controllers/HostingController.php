<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Playlist;
use App\Hosting;
use App\Battle;
use App\Genre;
use App\Enter;
use App\User;


class HostingController extends Controller
{
    /**
     * 
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */

    public function index(){
        $user=Auth::user()->id;
        //$h=Hosting::all();
        $h=Hosting::where('user_id',$user)->get();
        $p=Enter::where('user_id',$user)->get();

        return view('hosting.showMyParty', compact('h','p'));
    }

    /**
     * Show the form for creating a new resource
     * 
     * @return \Illuminate\Http\Response
     */

     public function create(){
         return view('hosting.new_party');
     }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            //campi obbligatori
            'name'=>'required',
            'mod'=>'required',
            'type'=>'required',
            'open'=>'required',
        ]);
        
        $a=Auth::user()->id;
        if(Hosting::where([['user_id', $a], ['online', 'yes']])->exists()){
           $hostingson = Hosting::where([['user_id', $a], ['online', 'yes']])->get();
           foreach ($hostingson as $hostingon) {
               $hostingon->online = "no";
               $hostingon->save();
            }
        }
       
        do{
            $code = Str::random(16);
            $url= "127.0.0.1:8000/hosting/show/".$code;
        }
        while(Hosting::where('url', '=', $url)->exists());
        
        $hosting = new Hosting([
            'user_id'=>$a,
            'name'=> $request->get('name'),
            'genre_id'=>$request->get('genre'),
            'mod'=> $request->get('mod'),
            'type'=> $request->get('type'),
            'open'=> $request->get('open'),
            'url'=>$url,
            'create_time' => Carbon::now()->toDateTimeString()
        ]);

        $hosting->save();
        $paperino = Hosting::where('url', $url)->value('id');
        return redirect()->route('hosting.show',$paperino);
        /*
        if($hosting->type=="battle"){
            return view('host.partybattle', compact('hosting'));
        }
        return view('host.partydemocracy', compact('hosting'));
        */
    }

     /**
      * Display the specified resource. 
      *
      * @param int $id
      * @return \Illuminate\Http\Response
      */

    public function show($id) {

        $user=Auth::user()->id;
        $playlist = Playlist::where('hosting_id', $id)->orderByDesc('votes')->get()->toJson();
        
        $battle = null;
        if (Battle::where('hosting_id', $id)->exists()) {
            $battle = Battle::where('hosting_id',$id)->first();
        }

        if (Hosting::where('id', $id)->exists()) {
            $hosting = Hosting::find($id);
            if ($hosting->user_id == $user) {
                if($hosting->type=="battle"){
                    return view('host.partybattle', compact('hosting', 'battle'));
                }
                return view('host.partydemocracy', compact('hosting', 'playlist'));
            } 
            else {
                return redirect('/dashboard')->with('error','That\'s not your party!');
                /*
                if($hosting->status=="online"){
                    if($hosting->type=="battle"){
                        return view('user.partybattle', compact('hosting', 'playlist'));
                    }
                return view('user.partydemocracy', compact('hosting', 'playlist'));
            */
            }
        }
        else {
            return redirect('/dashboard')->with('error','Party not found, sorry!');
        }
    }

    public function userShow($id) {
        
        $user = Auth::user()->id;
        $playlist = Playlist::where('hosting_id', $id)->get()->toJson();
        $battle = null;
        if (Battle::where('hosting_id', $id)->exists()) {
            $battle = Battle::where('hosting_id',$id)->first();
        }

        if (Hosting::where('id', $id)->exists()) {
            $hosting = Hosting::find($id);
            if (Enter::where([['user_id', $user],['hosting_id', $id]])->exists()) {
                $enter = Enter::where([['user_id', $user],['hosting_id', $id]])->first();
                $enter->status = "online";
                $enter->save();
                if ($hosting->type == "battle") {   
                    return view('utente.partybattle', compact('hosting', 'battle'));
                }
                return view('utente.partydemocracy', compact('hosting', 'playlist'));
            }
            else {
                return redirect('/dashboard')->with('error','You dind\'t join the party yet!');
            }
        }
        else {
            return redirect('/dashboard')->with('error','Party not found!');
        }
    }        

      /**
       * Show the form for editing the sepcified resource
       * 
       * @param int $id
       * @return \Illuminate\Http\Response
       */

       public function edit($id){
           $h=Hosting::find($id);
           return view('/hosting/party_edit',compact('h'));
       }

       /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */

        public function update(Request $request, $id){
            $request->validate([
                'name'=>'required',
                'mod'=>'required',
                'type'=>'required',
                'open'=>'required',
            ]);
            $h=Hosting::find($id);
            $h->name= $request->get('name');
            $h->genre_id=$request->get('genre');
            $h->mod= $request->get('mod');
            $h->type= $request->get('type');
            $h->open= $request->get('open');
            $h->save();

            return redirect('/hosting')->with('success','Party update!');
         }

        /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */ 
        
        public function destroy($id){
            $k=Hosting::find($id);
            $k->delete();
            return redirect('/hosting')->with('success','Party deleted!');
        }
        
        public function close($id){
            //chiudiamo il party
            $h=Hosting::find($id);
            $h->online='no';
            $h->save();
            //settiamo lo stato di tutti gli utenti che sono entrati nel party ad offline
            $enters = Enter::where('hosting_id', $id)->get();
            foreach($enters as $enter) {
                $enter->status = 'offline';
                $enter->save();
            }
            return view('/dashboard');
        }
}
