<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id')->unsigned();
            $table->string('type');
            $table->bigInteger('gun_id')->unsigned()->nullable();
            $table->bigInteger('caliber_id')->unsigned()->nullable();
            $table->bigInteger('corridor_id')->unsigned()->nullable();
            $table->double('quantity')->unsigned()->default(1);
            $table->double('unit_price')->unsigned();
            $table->double('total_price')->unsigned();
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('gun_id')->references('id')->on('guns')->onDelete('cascade');
            $table->foreign('caliber_id')->references('id')->on('calibers')->onDelete('cascade');
            $table->foreign('corridor_id')->references('id')->on('corridors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
