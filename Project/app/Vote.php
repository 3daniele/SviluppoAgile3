<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['battle_id','user_id',];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }   

    public function battle(){
        return $this->belongsTo('App\Battle');
    }
}
