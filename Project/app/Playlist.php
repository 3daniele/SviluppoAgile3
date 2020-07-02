<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['music_id','hosting_id',];
    public $timestamps = false;

    public function music() {
        return $this->belongsTo('App\Music');
    }   

    public function hosting(){
        return $this->belongsTo('App\Hosting');
    }

}
