<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = [
    	'image_src', 'name'
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function floorList()
    {
    	return $this->hasmany('App\Model\FloorList', 'floor_id', 'id');
    }
}
