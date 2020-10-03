<?php

namespace App;


use App\scopes\ReviserScope;

class reviser extends User
{
    protected $table = 'users';
    protected $guarded = [];
    protected static function booted()
    {
        static::addGlobalScope(new ReviserScope);
    }
    public function setRoleAttribute()
    {
        $this->attributes['role'] = 'مراجع فنى';
    }
    public function institution()
    {
        return $this->hasMany('App\Transaction','reviser_id');
    }
}
