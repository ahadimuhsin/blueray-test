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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id');
            // sender
            $table->string('sender_name');
            $table->text('sender_address');
            $table->string('sender_postal_code');
            $table->string('sender_phone');
            // recipient
            $table->string('recipient_name');
            $table->text('recipient_address');
            $table->string('recipient_postal_code');
            $table->string('recipient_phone');
            // items
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger("qty");
            $table->unsignedBigInteger('weight');
            $table->unsignedBigInteger('price');

            $table->foreign('creator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
