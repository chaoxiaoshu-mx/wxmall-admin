<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

	protected $fillable = [
    	'name', 'image_src', 'category_id', 'description'
    ];

    public function category()
    {
    	return $this->belongsTo('App\Model\ProductCategory', 'category_id', 'id');
    }
}
