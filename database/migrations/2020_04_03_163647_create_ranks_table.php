<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('color', 10)->default('#820505');
            $table->string('name', 25);
            $table->longtext('permissions')->default(serialize(array('usereditownprofile', 'postcreate', 'poststar')));
            $table->timestamps();
        });
        $rank = new App\Models\Rank();
        $rank->name = "ADMINISTRATOR";
        $perms = array('admin', 'categoryadd', 'categoryswitch', 'categorydelete', 'categoryedit', 'posterase', 'threaddelete', 'threadlock', 'threadcreate', 'posteraseself', 'poststar', 'postcreate', 'editownprofile', 'editotherprofile', 'ban');
        $rank->permissions = serialize($perms);
        $rank->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranks');
    }
}
