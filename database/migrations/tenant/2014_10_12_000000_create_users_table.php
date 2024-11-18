<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->integer('userID')->nullable();
            $table->tinyInteger('face_recognition')->nullable()->default(1);
            $table->longText('face_data')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('is_admin')->default(0);
            $table->tinyInteger('is_hr')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->cascadeOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->cascadeOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained('designations')->cascadeOnDelete();
            $table->text('permissions')->nullable();
            $table->string('verification_code')->nullable()->comment('email verification code');

            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->string('employee_id')->nullable();
            $table->enum('employee_type', ['Permanent', 'On Probation', 'Contractual', 'Intern'])->default('On Probation');
            $table->string('grade')->nullable();
            $table->string('nationality')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('instagram_link')->nullable();

            // passport
            $table->string('passport_number')->nullable();
            $table->foreignId('passport_file_id')->nullable()->constrained('uploads');
            $table->string('passport_expire_date')->nullable();
            $table->tinyInteger('passport_is_notified')->default(0);

            // eid
            $table->string('eid_number')->nullable();
            $table->foreignId('eid_file_id')->nullable()->constrained('uploads');
            $table->string('eid_expire_date')->nullable();
            $table->tinyInteger('eid_is_notified')->default(0);

            // visa
            $table->string('visa_number')->nullable();
            $table->foreignId('visa_file_id')->nullable()->constrained('uploads');
            $table->string('visa_expire_date')->nullable();
            $table->tinyInteger('visa_is_notified')->default(0);

            // insurance
            $table->string('insurance_number')->nullable();
            $table->foreignId('insurance_file_id')->nullable()->constrained('uploads');
            $table->string('insurance_expire_date')->nullable();
            $table->tinyInteger('insurance_is_notified')->default(0);

            // labour_card
            $table->string('labour_card_number')->nullable();
            $table->foreignId('labour_card_file_id')->nullable()->constrained('uploads');
            $table->string('labour_card_expire_date')->nullable();
            $table->tinyInteger('labour_card_is_notified')->default(0);

            // nid_card
            $table->string('nid_card_number')->nullable();
            $table->foreignId('nid_card_id')->nullable()->comment('this will be uploaded file')->constrained('uploads');

            //financial field
            $table->string('tin')->nullable();
            $table->string('tin_id_front_file')->nullable();
            $table->string('tin_id_back_file')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('last_login_device')->nullable();
            $table->string('device_uuid')->nullable();
            //emergency field
            $table->string('emergency_name')->nullable();
            $table->string('emergency_mobile_number')->nullable();
            $table->string('emergency_mobile_relationship')->nullable();

            $table->string('_token')->nullable()->comment('email verify token')->nullable();
            $table->string('email_verify_token')->nullable()->comment('email verify token');
            $table->enum('is_email_verified', ['verified', 'non-verified'])->default('verified');
            $table->timestamp('email_verified_at')->nullable()->comment('email verified at');
            $table->string('phone_verify_token')->nullable()->comment('phone verify token');
            $table->enum('is_phone_verified', ['verified', 'non-verified'])->default('verified');
            $table->timestamp('phone_verified_at')->nullable()->comment('phone verified at');
            $table->string('password');
            $table->string('password_hints')->nullable()->comment('user can set a password hint for easy remember');
            $table->foreignId('avatar_id')->nullable()->constrained('uploads');
            $table->foreignId('status_id')->index()->default(1)->constrained('statuses')->cascadeOnUpdate();
            $table->timestamp('last_login_at')->nullable()->comment('last login at');
            $table->timestamp('last_logout_at')->nullable()->comment('last logout at');
            $table->string('last_login_ip')->nullable()->comment('last login ip');
            $table->longText('device_token')->nullable()->comment('device_token from firebase');
            $table->tinyInteger('login_access')->default(1)->comment('0 = off, 1 = on');
            $table->string('address', 191)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Unisex', 'Others'])->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('religion', ['Islam', 'Hindu', 'Christian'])->default('Islam');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'])->nullable();
            $table->date('joining_date')->nullable();
            $table->double('basic_salary', 16, 2)->default(0);
            $table->enum('marital_status', ['Married', 'Unmarried'])->default('Unmarried');

            // set contract values
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->tinyInteger('payslip_type')->default(1)->comment('1 = monthly, 2 = weekly, 3 = daily');

            // set leave conditions
            $table->integer('late_check_in')->default(0);
            $table->integer('early_check_out')->default(0);
            $table->integer('extra_leave')->default(0);
            $table->integer('monthly_leave')->default(0);

            //is_free_location
            $table->tinyInteger('is_free_location')->default(0);
            // time zone set
            $table->string('time_zone', 191)->default('Asia/Karachi');
            $table->string('speak_language', 191)->default('english');
            $table->string('lang')->nullable();
            //social login
            $table->string('social_id')->nullable();
            $table->string('social_type')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->foreignId('face_image')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'status_id', 'company_id', 'branch_id', 'email', 'manager_id', 'role_id', 'designation_id', 'is_admin', 'is_hr', 'department_id', 'shift_id'], 'users_combined_index');

            // $table->string('stripe_id')->nullable()->index();
            // $table->string('pm_type')->nullable();
            // $table->string('pm_last_four', 4)->nullable();
            // $table->timestamp('trial_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
