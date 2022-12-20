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
        Schema::create('sub_sallaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_sallary')->index()->references('id')->on('sallaries')->onDelete('cascade');
            $table->string('product_category');
            $table->integer('quantity');
            $table->double('subtotal');
            $table->double('total');
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
        Schema::dropIfExists('sub_sallaries');
    }
};
