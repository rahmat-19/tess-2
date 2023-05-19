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
        Schema::create('greeting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('domain_id');
            $table->longText('greeting_word');
            $table->string('name_guest');
            $table->boolean('kehadiran');
            $table->foreign('domain_id')->references('id')->on('subdomain')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('greeting');
    }
};
