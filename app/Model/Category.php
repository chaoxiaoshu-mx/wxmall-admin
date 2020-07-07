<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Category extends Model
{
     use SoftDeletes;

     protected $fillable = [
    	'title', 'parent_id', 'level', 'icon', 'checked'
    ];

    protected $hidden = [
    	'created_at', 'updated_at', 'deleted_at'
    ];

    public static function getTree() 
    {
    	$list = self::get()->toArray();
    	$tree = [];

        self::ListToTree($list,'id','parent_id','children',0,$tree);

        return $tree;
    }
    public static function ListToTree($list, $primaryKey='id', $parentKey = 'pid', $childStr = 'children', $root = 0 ,array &$tree)
    {
        if (is_array($list)) {
 			
            //创建基于主键的数组引用
            $refer = array();
 
            foreach ($list as $key => $data) {
                $refer[$data[$primaryKey]] = &$list[$key];
            }
 
            foreach ($list as $key => $data) {
 
                //判断是否存在parent
                $parantId = $data[$parentKey];
 		
                if ($root == $parantId) {
                    $tree[] = &$list[$key];
                    // array_slice($tree, 0, $offset),
                } else {
 
                    if (isset($refer[$parantId])) {
                        $parent = &$refer[$parantId];
                        $parent[$childStr][] = &$list[$key];
                    }
 
                }
            }
        }
 
        return $tree;
    }
}
