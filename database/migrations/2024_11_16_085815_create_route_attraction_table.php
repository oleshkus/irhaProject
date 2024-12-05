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
        Schema::create('route_attraction', function (Blueprint $table) {
            $table->id();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('attraction_id')->constrained()->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_attraction');
    }
};
