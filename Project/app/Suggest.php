<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $table = 'Suggests';
    protected $fillable = ['music_id','hosting_id', 'user_id', 'created_at', 'updated_at'];
    public $timestamps = false;

    public function music() {
        return $this->belongsTo('App\Music');
    }   

    public function hosting(){
        return $this->belongsTo('App\Hosting');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
