<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Settings;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('color', 10)->default('#0b1e4a');
            $table->integer('default_rank')->default(1);
            $table->boolean('editormode')->default(0);
            $table->integer('thread_title_length')->default(50);
            $table->integer('thread_op_length')->default(2000);
            $table->integer('thread_post_length')->default(2000);
            $table->integer('profile_name_length')->default(15);
        });
        DB::statement("ALTER TABLE settings ADD profile_default_avatar MEDIUMBLOB SET DEFAULT " . "`" . base64_encode(asset('default_avatar.png')) . "`");
        $s = new Settings();
        $s->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
