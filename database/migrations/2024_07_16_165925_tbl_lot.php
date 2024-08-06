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
        Schema::create("tbl_lot",function (Blueprint $table){
            $table->id();
            $table->integer('status');
            $table->foreignId('auction_id')->references('id')->on('tbl_auction')->constrained()->onDelete('cascade');
            $table->integer('lot_num');
            $table->string('title');
            $table->text('description');
            $table->decimal('start_bid');
            $table->decimal('next_bid');
            $table->decimal('reserve_bid')->nullable();
            $table->decimal('buyer_premium')->nullable();
            $table->decimal('store_price')->nullable();
            $table->string('category')->nullable();
            $table->string('condition')->nullable();
            $table->string('img');
            $table->string('dimension')->nullable();
            $table->string('ship_info')->nullable();
            $table->decimal('ship_cost')->nullable();
            $table->string('ship_restriction')->nullable();
            $table->integer('pickup')->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('pickup_instruction')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_lot');
    }
};
