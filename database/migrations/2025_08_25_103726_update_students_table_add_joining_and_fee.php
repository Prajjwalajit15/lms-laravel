<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'join_from')) {
                $table->date('join_from')->nullable()->after('address');
            }
            if (!Schema::hasColumn('students', 'join_to')) {
                $table->date('join_to')->nullable()->after('join_from');
            }
            if (!Schema::hasColumn('students', 'total_days')) {
                $table->integer('total_days')->nullable()->after('join_to');
            }
            if (!Schema::hasColumn('students', 'fee')) {
                $table->decimal('fee', 10, 2)->nullable()->after('total_days');
            }
            if (Schema::hasColumn('students', 'dob')) {
                $table->dropColumn('dob'); // remove DOB
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'join_from')) $table->dropColumn('join_from');
            if (Schema::hasColumn('students', 'join_to')) $table->dropColumn('join_to');
            if (Schema::hasColumn('students', 'total_days')) $table->dropColumn('total_days');
            if (Schema::hasColumn('students', 'fee')) $table->dropColumn('fee');
            if (!Schema::hasColumn('students', 'dob')) $table->date('dob')->nullable()->after('course');
        });
    }
};
