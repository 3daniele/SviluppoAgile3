<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enter extends Model
{
    protected $fillable = ['user_id','hosting_id', 'created_at', 'updated_at'];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }   

    public function hosting(){
        return $this->belongsTo('App\Hosting');
    }

}
