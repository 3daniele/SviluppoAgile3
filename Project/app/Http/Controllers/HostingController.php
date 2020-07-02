<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Hosting;
use App\User;
use App\Genre;

class HostingController extends Controller
{
    /**
     * 
     * Display a listing of the resource
     * 
     * @return \Illuminate\Http\Response
     */

    public function index(){
        return view('/hosting.new_party');
    }

    /**
     * Show the form for creating a new resource
     * 
     * @return \Illuminate\Http\Response
     */

     public function create(){
         return view('hosting.create');
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
        
        $hosting = new Hosting([
            'user_id'=>$a,
            'name'=> $request->get('name'),
            'genre_id'=>$request->get('genre'),
            'mod'=> $request->get('mod'),
            'type'=> $request->get('type'),
            'open'=> $request->get('open')
        ]);

        $hosting->save();
        return redirect('/dashboard')->with('success', 'contact saved!');

    }

     /**
      * Display the specified resource. 
      *
      * @param int $id
      * @return \Illuminate\Http\Response
      */

      public function show($id){
          //
      }

      /**
       * Show the form for editing the sepcified resource
       * 
       * @param int $id
       * @return \Illuminate\Http\Response
       */

       public function edit($id){
           //
       }

       /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */

        public function update(Request $request, $id){
            //
         }

        /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        
        public function destroy($id){
            //
        }
}
