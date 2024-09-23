<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->foreign('post_id')->references('post_id')->on('posts')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::table('category_post', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['post_id']);
        });
        Schema::dropIfExists('category_post');
    }
};
