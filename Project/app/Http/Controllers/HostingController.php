<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\DB;
use Illuminate\Http\Request;
use App\Hosting;
use App\User;
use App\Genre;
use Carbon\Carbon;
use Illuminate\Support\Str;
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
        return view('hosting.showMyParty', compact('h'));
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
        return redirect('/dashboard')->with('success', 'contact saved!');

    }

      /**
      * Display all the resource associated for the user. 
      *
      * @return \Illuminate\Http\Response
      */

      public function showall(){
        $hosting=null;
      }


     /**
      * Display the specified resource. 
      *
      * @param int $id
      * @return \Illuminate\Http\Response
      */

      public function show($id){
        $hosting= null;
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
}
