<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=['id','roleName','permission'];

   /* public function user(){
        //return $this->belongsTo('App\Models\User','user_id');
        return $this->hasMany('App\Models\User','role_id');
    }*/
}
