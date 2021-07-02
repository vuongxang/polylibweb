<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
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
            DB::table('categories')->insert($item);
        }
    }
}
