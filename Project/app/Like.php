<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id','music_id'];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }   

    public function music(){
        return $this->belongsTo('App\Music');
    }
}
