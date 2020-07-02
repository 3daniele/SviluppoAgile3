<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $fillable = ['url','votes','active'];
    public $timestamps = false;

    public function playlist( ){
        return $this->hasMany("App\Playlist");
    }
}
