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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('title_slug')->nullable();
            $table->string('image')->nullable();
            $table->text('content')->nullable();
            $table->text('tags')->nullable();
            $table->integer('breaking_news')->nullable();
            $table->integer('top_slider')->nullable();
            $table->integer('first_section_three')->nullable();
            $table->integer('first_section_nine')->nullable();
            $table->string('post_date')->nullable();
            $table->string('post_month')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->integer('view_count')->default(0)->nullable();
            $table->integer('trust_factor')->nullable();
            $table->boolean('reviewed')->default('0');
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
        Schema::dropIfExists('articles');
    }
};
