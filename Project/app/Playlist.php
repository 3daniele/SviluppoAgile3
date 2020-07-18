<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['playlist_id','hosting_id',];
    public $timestamps = false;

    public function playlist() {
        return $this->belongsTo('App\Playlist');
    }   

    public function hosting(){
        return $this->belongsTo('App\Hosting');
    }

}
