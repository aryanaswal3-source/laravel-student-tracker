<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_student_attendance', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent'])->default('absent');
            $table->timestamps();

            $table->foreign('student_id')
                  ->references('id')
                  ->on('tbl_personal_details')
                  ->onDelete('cascade');

            // Ek student ka ek din mein sirf ek hi attendance record ho sakta hai
            $table->unique(['student_id', 'attendance_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_student_attendance');
    }
};