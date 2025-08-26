<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Change ENUM to include 'Not Available'
            $table->enum('status', ['Available', 'Borrowed', 'Not Available'])
                  ->default('Available')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Revert to previous ENUM
            $table->enum('status', ['Available', 'Borrowed'])
                  ->default('Available')
                  ->change();
        });
    }
};

