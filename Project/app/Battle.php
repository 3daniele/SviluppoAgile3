<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    protected $fillable = ['uri1','uri2','hosting_id','votes'];
    public $timestamps = false;

    public function music() {
        return $this->belongsTo('App\Music');
    }  
    
    public function hosting() {
        return $this->belongsTo('App\Hosting');
    }
}
