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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('product_code',255)->nullable();
            $table->string('brand',255)->nullable();
            $table->string('model',255)->nullable();
            $table->string('title',255)->nullable();
            $table->string('color',255)->nullable();
            $table->mediumText('description')->nullable();
            $table->integer('price')->nullable();
            $table->string('phone')->nullable();
            $table->integer('optional_phone')->nullable();
            $table->mediumText('thumbnail')->nullable();
            $table->mediumText('images')->nullable();
            $table->integer('discount')->default(0)->nullable();
            $table->integer('position')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('products');
    }
};
