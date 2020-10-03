<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class institution extends Model
{
    //

    protected $guarded = [];


    public function agent(){
        return $this->belongsTo('App\User','agent_id');
    }
    public function TradeRegisters()
    {
        return $this->hasMany('App\TradeRegister','institution_id');
    }
    public function Transactions(){
        return $this->hasMany('App\Transaction','institution_id');
    }
}
