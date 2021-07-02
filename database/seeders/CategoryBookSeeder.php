<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=10;$i++){
                $item = [
                    'book_id' => $i,
                    'cate_id' => rand(1,9),
                ];
                DB::table('category_books')->insert($item);
        }
    }
}
