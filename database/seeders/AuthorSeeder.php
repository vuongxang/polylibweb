<?php

namespace Database\Seeders;

use Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name;
            // $slug = str_slug($name, '-');
            $item = [
                'name' => $name,
                'avatar' => $faker->imageUrl(70, 70, 'people'),
                'description' => $faker->realText(50, 1),
                'date_birth'  => $faker->dateTime($max = 'now', $timezone = null),

            ];
            DB::table('authors')->insert($item);
        }
    }
}
