<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSlidersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sliders', function (Blueprint $table) {
            //
            $table->string('status')->default(0)->after('image_name');
            $table->unsignedBigInteger('user_id')->after('status');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sliders', function (Blueprint $table) {
            //
        });
    }
}
