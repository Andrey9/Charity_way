<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->integer('price')->nullable();
            $table->integer('volume')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('position')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('image',255)->nullable();

            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
