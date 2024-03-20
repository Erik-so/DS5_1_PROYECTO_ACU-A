<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('publication');
            $table->integer('user_id');
            $table->integer('like')->nullable();
            $table->integer('saved')->nullable();
            $table->integer('hashtag_id');
            $table->string('images');
            $table->integer('comment_id')->nullable();
            $table->integer('sponsor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
