<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Category extends Model
{
     use SoftDeletes;

     protected $fillable = [
    	'name', 'parent_id', 'level', 'icon'
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
