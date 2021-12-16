<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->boolean('available')->nullable();

            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->boolean('available')->nullable();
            
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('set null')->onUpdate('cascade');
        });
    }
}
