<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email', 320)->unique();
            $table->string('name', 30)->unique();
            $table->string('password', 60);
            $table->string('remember_token', 100)->nullable();
            $table->string('role', 15)->nullable();
            $table->integer('score')->default(0);
            $table->boolean('banned')->default(0);
            $table->timestamp('last_login')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
        DB::statement("ALTER TABLE users ADD avatar MEDIUMBLOB");
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
