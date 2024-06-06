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
        Schema::create('contact_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade');
            $table->string('street');
            $table->string('between_streets');
            $table->string('zip');
            $table->string('city');
            $table->string('state');
            $table->string('num_ext');
            $table->string('num_int');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_addresses');
    }
};
