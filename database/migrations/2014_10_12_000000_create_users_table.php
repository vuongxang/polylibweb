<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('phone')->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('gender')->nullable();
            $table->string('google_id')->nullable();
            $table->string('avatar')->default('https://c0.klipartz.com/pngpicture/136/22/gratis-png-perfil-de-usuario-computadora-iconos-chica-cliente-avatar.png');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role_id')->default(4);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
