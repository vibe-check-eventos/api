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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('participant_id');
            $table->foreignId('event_id');
            $table->foreign("participant_id")->references("id")->on("participants");            
            $table->foreign("event_id")->references("id")->on("events"); 
            $table->text('qr_code_base64')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
