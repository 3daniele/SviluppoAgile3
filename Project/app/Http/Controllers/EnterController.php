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
        return view('utente.join');
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
        
        //controlliamo se l'utente è già nella lista dei partecipanti
        //Select *from(entrata) where (id_utente=utente AND hosting_id=hosting)
        //se restituisce un valore diverso da null setto status su online e faccio il redirect altrimenti 
        //memorizzo e faccio il redirect

        $registrato=Enter::where('hosting_id',$hosting_id && 'user_id',$id)->first();

        if($registrato==null){
        //store vera e propria
        $enter = new Enter([
            'user_id' => $id,
            'hosting_id'=> $hosting_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $enter->save();
        }else{
            $registrato->status="online";
            $registrato->save();
        }
        
        $hosting_type=Hosting::where('url',$url)->value('type');
        if($hosting_type=="battle"){
            return view('utente.partybattle', compact('hosting_id'));//
        }
        return view('utente.partydemocracy', compact('hosting_id')); 
    }
    

    public function exitP() {
        $id=Auth::user()->id;
        $online=Enter::where('status','online' && 'user_id',$id)->first();

        $online->status="offline";
        $online->save();
        return redirect('dashboard')->with('success','Status update!');
        
    }
}
