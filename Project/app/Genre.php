<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false; 

    public function hosting() {
        return $this->hasMany('App\Hosting');
    }
}
