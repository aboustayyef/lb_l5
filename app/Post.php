<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'posted_at'
    ]; 
    //
    public static function uid_exists($uid)
    {
        return Static::where('uid',$uid)->count() > 0;
    }
}