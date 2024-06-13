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
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('title_slug')->unique();
            $table->text('content');
            $table->text('tags')->nullable();
            $table->boolean('breaking_news')->default(false);
            $table->boolean('top_slider')->default(false);
            $table->boolean('first_section_three')->default(false);
            $table->boolean('first_section_nine')->default(false);
            $table->date('post_date');
            $table->string('post_month');
            $table->string('image');
            $table->boolean('reviewed')->default(false);
            $table->integer('trustfactor')->nullable();
            $table->text('admin_comment')->nullable();
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
