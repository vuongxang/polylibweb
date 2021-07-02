<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class BookGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i =1 ;$i<=10;$i++){
            for($j=0;$j<5;$j++){
                $item = [
                    'book_id' => $i,
                    'url' => $faker->imageUrl($width = 640, $height = 1000),
                ];
                DB::table('book_galleries')->insert($item);
            }
        }
    }
}
