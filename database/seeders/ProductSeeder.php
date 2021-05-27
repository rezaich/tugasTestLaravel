<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name'=>'bloon bl03',
            'price'=> 300000,
            'description'=>'Bloon banget',
            'image_link'=>'jpeg',
            'category_id'=> 1,
            'status'=>'public'
        ]);

        DB::table('products')->insert([
            'name'=>'trn v80',
            'price'=> 400000,
            'description'=>'trn lapan puluh',
            'image_link'=>'png',
            'category_id'=>1,
            'status'=>'public'
        ]);
        DB::table('products')->insert([
            'name'=>'Anonibuds QCC010',
            'price'=> 400000,
            'description'=>'alien secret',
            'image_link'=>'png',
            'category_id'=>3,
            'status'=>'public'
        ]);
    }
}
