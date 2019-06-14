<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTags extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tags', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name', 100);
      $table->string('color', 6);
    });

    Schema::create('posts', function (Blueprint $table) {
      $table->increments('id');
      $table->text('title');
      $table->longText('content');
      $table->timestamps();
      $table->unsignedInteger('author_id');
      $table->tinyInteger('private');
      $table->tinyInteger('draft');
    });

    Schema::create('post_tag_xref', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('post_id');
      $table->unsignedInteger('tag_id');

      $table->foreign('tag_id')->references('id')->on('tags');
      $table->foreign('post_id')->references('id')->on('posts');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('tags');

    Schema::drop('post_tag_xref');
  }
}
