<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Enter;
use App\Hosting;
use App\User;

class EnterController extends Controller
{
    public function index() {
        return view('enter.join');
    }
    
    public function store(Request $request) {
        $request->validate([
            //campi obbligatori
            'url'=>'required',
        ]);

        $id = Auth::user()->id;
        $url = $request->get('url');
        //Controllo se esiste

        //Se esiste prelevo l'id del party

        //memorizzo l'entrata nel DB
        $esiste=Hosting::where('url', $url)->get();
        if (!$esiste){
            return response(['error'=>'url not valid'],404);
        }

        //$hosting_id=Hosting::find($url)->get('id');
        $hosting_id=Hosting::where('url', $url)->value('id');
        //store vera e propria
        $enter = new Enter([
            'user_id' => $id,
            'hosting_id'=> $hosting_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $enter->save();
        return redirect('dashboard'); 
    }

    public function exitP($id) {

    }
}
