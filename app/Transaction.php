<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $guarded = [];

    public function reviser(){
        return $this->belongsTo('App\reviser','reviser_id');
    }

    public function institution(){
        return $this->belongsTo('App\institution','institution_id');
    }

    public function documentations(){
        return $this->belongsToMany('App\document');
    }
}
