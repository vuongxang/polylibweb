<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostShareCateDetailSeeder extends Seeder
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
                'post_id' => $i,
                'cate_id' => rand(1,11),
            ];
            DB::table('post_share_category_details')->insert($item);
    }
}
}