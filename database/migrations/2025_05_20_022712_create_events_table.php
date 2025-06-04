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
        //foreign('user_id')->references('id')->on('users');
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id');
            $table->foreign("organizer_id")->references("id")->on("organizers")->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->integer('capacity')->nullable();
            $table->foreignId('event_address_id');
            $table->foreign("event_address_id")->references("id")->on("event_addresses")->nullable();
            $table->dateTime('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
