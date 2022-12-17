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
        Schema::create('sallaries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_user')->index()->references('id')->on('users')->onDelete('cascade');
            $table->double('total_sallary')->default(0);
            $table->enum('order_status', ['paid', 'not_paid']);
            $table->date('period');
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
        Schema::dropIfExists('sallaries');
    }
};