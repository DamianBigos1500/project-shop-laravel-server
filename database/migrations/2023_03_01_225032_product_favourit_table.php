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
        Schema::create("favourit_collection_product", function(Blueprint $table){
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('favourit_collection_id');

            $table->foreign("product_id")->references('id')->on('products')->onDelete("cascade");
            $table->foreign("favourit_collection_id")->references('id')->on('favourit_collections')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_favourit');
    }
};
