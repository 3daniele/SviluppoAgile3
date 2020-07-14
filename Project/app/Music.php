<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $table = 'Musics';
    protected $fillable = ['uri','votes','active'];
    public $timestamps = false;

    public function playlist( ){
        return $this->hasMany("App\Playlist");
    }
}
