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
        Schema::table('lombas', function (Blueprint $table) {
            $table->date('end_date')
                ->after('release_date');

            $table->enum('location_type', [
                'online',
                'offline'
            ])->after('end_date');

            $table->string('location')
                ->nullable()
                ->after('location_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn([
                'end_date',
                'location_type',
                'location'
            ]);
        });
    }
};
