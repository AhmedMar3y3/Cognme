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
        Schema::create('emergency_contacts', function (Blueprint $table) {
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->string('name');
            // $table->string('image');
            // $table->string('contact');
            // $table->foreign('user_id')
            // ->references('id')
            // ->on('users')
            // ->onDelete('cascade');
            // $table->timestamps(); 
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('image');
            $table->string('contact');
            $table->string('relation');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};
