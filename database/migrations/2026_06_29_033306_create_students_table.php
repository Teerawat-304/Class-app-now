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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name'); //เพิ่ม attribute ที่ต้องการ
            $table->string('student_id')->unique();
            $table->string('faculty_id')->nullable();
            $table->string('program_id')->nullable();
        
            $table->date('birth_date');
            $table->string('email');
            $table->string('address');
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
            // crate foreign key
            $table->foreign('faculty_id')
                ->references('faculty_id')
                ->on('faculty')
                ->onDelete('set null');
            
            $table->foreign('program_id')
                ->references('program_id')
                ->on('program')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
