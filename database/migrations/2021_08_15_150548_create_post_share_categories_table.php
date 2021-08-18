<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostShareCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_share_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->unique();
            $table->string('slug',255)->unique();
            $table->integer('status')->default(1);
            $table->string('image', 191)->default('images/default.jpg');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_share_categories');
    }
}
