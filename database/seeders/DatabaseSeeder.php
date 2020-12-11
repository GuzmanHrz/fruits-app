<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $names = ["apples","pears","Watermelon"];
        $sizes = ["small","medium","large"];
        $colors = ["green", "yellow"];

        foreach ($names as $name) {
            foreach ($sizes as $size) {
                DB::table('fruits')->insert([
                    'name'  => $name,
                    'size'  => $size,
                    'color' => $colors[array_rand($colors,1)],
                    "created_at" =>  Carbon::now(), 
                    "updated_at" =>  Carbon::now()
                ]);
            }
        }
    }
}
