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
        Schema::table('beritas', function (Blueprint $table) {

            $table->text('excerpt')
                ->nullable()
                ->after('title');

            $table->string('author')
                ->default('Admin')
                ->after('excerpt');

            $table->string('source')
                ->nullable()
                ->after('author');
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {

            $table->dropColumn([
                'excerpt',
                'author',
                'source'
            ]);
        });
    }
};
