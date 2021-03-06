<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CateItem extends Model
{
    protected $fillable = [
    	'image_src', 'navigator_url', 'open_type', 'name'
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
