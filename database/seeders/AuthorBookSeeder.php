<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorBookSeeder extends Seeder
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
                'author_id' => rand(1,11),
            ];
            DB::table('author_books')->insert($item);
    }
    }
}
