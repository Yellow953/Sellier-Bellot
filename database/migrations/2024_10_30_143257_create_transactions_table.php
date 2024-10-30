<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('transaction_date');
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_phone');
            $table->string('verification');
            $table->string('gun_source');
            $table->string('ammo_source');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
