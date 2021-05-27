<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name'=> 'IEM'
        ]);

        DB::table('categories')->insert([
            'name'=> 'OEM'
        ]);

        DB::table('categories')->insert([
            'name'=> 'TWS'
        ]);
    }
}
