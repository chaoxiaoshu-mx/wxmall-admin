<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'title' => '分类',
            'parent_id' => '0',
            'level' => '0',
            'icon'	=> '',
            'checked'   => true,
            'spread'   => true
            
        ]);

    }
}
