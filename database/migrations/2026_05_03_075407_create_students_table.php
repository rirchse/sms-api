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
            $table->foreignId('school_id')->constrained();
            $table->foreignId('user_id')->nullable();
            
            // Student Information
            $table->string('name_en')->nullable();
            $table->string('name_bn')->nullable();
            $table->string('name_ar')->nullable();
            $table->date('dob')->nullable();
            $table->string('birth_certificate_no')->nullable();
            $table->string('gender')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('age')->nullable();
            $table->string('nationality')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('identify_sign')->nullable();
            $table->string('present_village')->nullable();
            $table->string('present_post')->nullable();
            $table->string('present_upazilla')->nullable();
            $table->string('present_post_code')->nullable();
            $table->string('present_zilla')->nullable();
            $table->string('permanent_village')->nullable();
            $table->string('permanent_post')->nullable();
            $table->string('permanent_upazilla')->nullable();
            $table->string('permanent_zilla')->nullable();
            $table->string('permanent_post_code')->nullable();

            // Guardian Information
            $table->string('father_name_bn')->nullable();
            $table->string('father_name_en')->nullable();
            $table->string('father_education')->nullable();
            $table->string('father_occupation')->nullable();
            $table->decimal('father_monthly_earning', 10, 2)->default(0.00);
            $table->string('father_mobile_no')->nullable();
            $table->string('father_nid_no')->nullable();
            $table->date('father_dob')->nullable();
            $table->string('mother_name_bn')->nullable();
            $table->string('mother_name_en')->nullable();
            $table->string('mother_education')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->decimal('mother_monthly_earning', 10, 2)->default(0.00);
            $table->string('mother_mobile_no')->nullable();
            $table->string('mother_nid_no')->nullable();
            $table->date('mother_dob')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_student_relation')->nullable();
            $table->string('guardian_present_address')->nullable();
            $table->string('guardian_permanent_address')->nullable();
            $table->string('guardian_education')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->decimal('guardian_monthly_earning', 10, 2)->default(0.00);
            $table->string('guardian_mobile_no')->nullable();
            $table->string('guardian_nid_no')->nullable();
            $table->date('guardian_dob')->nullable();
            $table->string('class_name')->nullable(); 
            $table->string('session_name')->nullable();
            $table->string('division')->nullable();
            
            // Detailed Address Information
            $table->string('previous_institute_name')->nullable();
            $table->string('sibling_details')->nullable();

            // Documents
            $table->string('student_photo')->nullable();
            $table->string('student_signature')->nullable();

            // Lifecycle & Payment
            $table->string('status')->nullable(); 
            $table->decimal('application_fee', 10, 2)->default(0.00); // Crucial for your form logic
            $table->string('payment_tracking_id')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->timestamps();
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
