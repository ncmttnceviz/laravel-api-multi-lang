<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTranslatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_translates', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->text('content');
            $table->foreignId('article_id')->references('id')->on('articles');
            $table->foreignId('language_id')->references('id')->on('languages');
            $table->index(['article_id','language_id']);
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
        Schema::dropIfExists('article_translates');
    }
}
