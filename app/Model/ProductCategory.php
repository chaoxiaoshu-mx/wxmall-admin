<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
    	'name'
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    public function product()
    {
    	return $this->hasMany('App\Model\Product', 'category_id', 'id');
    }
}
