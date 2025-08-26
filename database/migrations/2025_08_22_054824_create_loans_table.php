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
    Schema::create('loans', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('book_id');
        $table->unsignedBigInteger('student_id');
        $table->date('loan_date');
        $table->date('return_date'); // due date
        $table->date('actual_return_date')->nullable(); // when book actually returned
        $table->decimal('late_fee', 8, 2)->default(0); // fine amount
        $table->enum('status', ['active', 'returned'])->default('active');
        $table->timestamps();

        // Foreign keys
        $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
