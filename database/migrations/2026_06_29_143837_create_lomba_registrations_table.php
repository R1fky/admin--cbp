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
        Schema::create('lomba_registrations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('lomba_id')
                ->constrained('lombas')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->text('address');

            $table->string('file')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lomba_registrations');
    }
};
