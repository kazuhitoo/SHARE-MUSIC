<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->dateTime('created_at')->nullable()->comment('登録日時');
            $table->dateTime('updated_at')->nullable()->comment('更新日時');
            $table->unsignedBigInteger('user_id')->comment('ユーザID');
            $table->unsignedBigInteger('music_id')->comment('音楽ID');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('music_id')->references('id')->on('music')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
};
