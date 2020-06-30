<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FloorList extends Model
{
    protected $fillable = [
    	'image_src', 'name', 'floor_id', 'open_type'
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
    public function floor()
    {
    	return $this->belongsTo('App\Model\Floor', 'floor_id', 'id');
    }
}
