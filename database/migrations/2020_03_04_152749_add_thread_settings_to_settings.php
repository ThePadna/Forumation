<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreadSettingsToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('thread_title_length')->default(200);
            $table->integer('thread_op_length')->default(2000);
            $table->integer('thread_post_length')->default(2000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('thread_title_length');
            $table->dropColumn('thread_op_length');
            $table->dropColumn('thread_post_length');
        });
    }
}
