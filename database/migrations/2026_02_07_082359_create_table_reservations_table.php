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
        Schema::create('table_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', [
                'reserved',
                'occupied',
                'completed',
                'cancelled'
            ])->default('reserved');
            $table->timestamps();

            $table->index(['date', 'start_time', 'end_time']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_reservations');
    }
};
