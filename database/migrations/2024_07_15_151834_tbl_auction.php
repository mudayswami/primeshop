<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("tbl_auction", function (Blueprint $table){
            $table->id();   
            $table->integer('status')->default(1);
            $table->string("title");
            $table->text("description");
            $table->string('img');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('type');
            $table->string('category');
            $table->integer('lots');
            $table->text('terms_and_conditions');
            $table->integer('buyer_premium');
            $table->integer('seller_commission');
            $table->integer('fees');
            $table->integer('vat_rate');
            $table->integer('other_tax');
            $table->timestamps();   
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_auction');
    }
};
