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

            $table->foreignId('kategori_id')
                ->nullable()
                ->after('title')
                ->constrained('kategori_lombas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {

            $table->dropForeign(['kategori_id']);

            $table->dropColumn('kategori_id');
        });
    }
};
