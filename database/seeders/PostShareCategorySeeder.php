<?php

namespace Database\Seeders;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostShareCategorySeeder extends Seeder
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
            $name = $faker->name;
            // $slug = str_slug($name, '-');
            $item = [
                'name' => $name,
                'description' => $faker->realText(50, 1),
                'slug' => str_slug($name, '-'),
            ];
            DB::table('post_share_categories')->insert($item);
        }
    }
}
