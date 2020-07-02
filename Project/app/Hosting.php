<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{


    protected $fillable=["user_id", "name", "mod", "type", "genre_id", "open"];
    public $timestamps=false;

    public function user( ){
        return $this->belongsTo("App\User");
    }
    public function genre( ){
        return $this->belongsTo("App\Genre");
    }

    public function enter( ){
        return $this->hasMany("App\Enter");
    }

    public function playlist( ){
        return $this->hasMany("App\Playlist");
    }

    public function banUser( ){
        return $this->hasMany("App\BanUser");
    }

}
