<?php

namespace App;


use App\scopes\EmployeesScope;

class employee extends User
{
    protected $table = 'users';
    protected $guarded = [];
    protected static function booted()
    {
        static::addGlobalScope(new EmployeesScope);
    }

}
