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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->integer('kode_referal');
            $table->unsignedBigInteger('village_id')->nullable();
            $table->unsignedBigInteger('subdomain_id')->nullable();
            $table->string('remember_token')->nullable();
            $table->foreign('village_id')->references('id')->on('village');
            $table->foreign('subdomain_id')->references('id')->on('subdomain');
            $table->timestamps();
        });

        Schema::table('subdomain', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
