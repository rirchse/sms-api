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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            // Relationships
            $table->foreignId('school_id')->constrained();
            $table->foreignId('user_id')->nullable();
            
            // Student Information
            $table->string('class_name')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('stay_type')->nullable();

            // Guardian Information
            $table->string('father_name')->nullable(); 
            $table->string('mother_name')->nullable(); 
            $table->string('guardian_name')->nullable();
            $table->string('guardian_occupation')->nullable(); 
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_email')->nullable();
            
            // Detailed Address Information
            $table->string('upozilla')->nullable();
            $table->string('union_pourosova')->nullable();
            $table->string('ward')->nullable(); 
            $table->string('village_moholla')->nullable(); 

            // Documents
            $table->string('student_photo_path')->nullable();
            $table->string('birth_certificate_path')->nullable();

            // Lifecycle & Payment
            $table->string('status')->nullable(); 
            $table->decimal('application_fee', 10, 2)->default(0.00); // Crucial for your form logic
            $table->string('payment_tracking_id')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('password_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
