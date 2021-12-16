<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title', 100);
            $table->string('short_description', 100);
            $table->text('description');
            $table->string('image', 100);
            $table->string('banner', 100);
            $table->boolean('female')->nullable();
            $table->boolean('male')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('new_price', 10, 2)->nullable();
            $table->char('discount')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('available')->nullable();
            $table->string('slug', 100);
            $table->timestamps();
            
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
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
}
