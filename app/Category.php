<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Category extends Model
{
    //
    protected $table = 'categories';

    public function posts(){
        return $this->hasMany('App\Post');
    }

}
