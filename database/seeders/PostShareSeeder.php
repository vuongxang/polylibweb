<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class PostShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i =0 ;$i<10;$i++){
            $title = $faker->name;
            $slug = str_slug($title, '-');
            $item = [
                'title' => $title,
                'slug' =>$slug."-".($i+1),
                'user_id' => 1,
                'status' => 1,
                'content' => $faker->realText(50, 1),
            ];
            DB::table('post_shares')->insert($item);
        }
    }
}
