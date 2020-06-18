<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Swiper extends Model
{
    protected $fillable = [
    	'image_src', 'navigator_url', 'open_type', 'goods_id'
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
