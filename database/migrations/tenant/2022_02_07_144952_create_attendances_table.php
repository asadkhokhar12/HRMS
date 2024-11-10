<?php

use App\Enums\AttendanceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();
            $table->string('stay_time')->nullable();
            $table->string('late_reason')->nullable();
            $table->integer('late_time')->default(0);
            $table->enum('in_status', ['OT', 'L', 'A'])->nullable()->default(AttendanceStatus::ON_TIME)->comment('OT=On Time, L=Late, A=Absent');
            $table->enum('out_status', ['LT', 'LE', 'LL'])->nullable()->default(null)->comment('LT=Left Timely, LE=Left Early, LL = Left Later');
            $table->string('checkin_ip')->nullable();
            $table->string('checkout_ip')->nullable();

            //location columns
            $table->boolean('remote_mode_in')->nullable()->default(0)->comment('0 = home , 1 = office');
            $table->boolean('remote_mode_out')->nullable()->default(0)->comment('0 = home , 1 = office');
            $table->string('check_in_location')->nullable();
            $table->string('check_out_location')->nullable();
            $table->double('check_in_latitude')->comment('check in latitude')->nullable();
            $table->double('check_in_longitude')->comment('check in longitude')->nullable();
            $table->double('check_out_latitude')->comment('check out latitude')->nullable();
            $table->double('check_out_longitude')->comment('check out longitude')->nullable();
            $table->string('check_in_city')->comment('city')->nullable();
            $table->string('check_in_country_code')->comment('countryCode')->nullable();
            $table->string('check_in_country')->comment('country')->default('Bangladesh')->nullable();
            $table->string('check_out_city')->comment('city')->nullable();
            $table->string('check_out_country_code')->comment('countryCode')->nullable();
            $table->string('check_out_country')->comment('country')->default('Bangladesh')->nullable();
            $table->foreignId('status_id')->default(1)->constrained('statuses');
            $table->foreignId('face_image')->nullable()->constrained('uploads')->onDelete('cascade');

            $table->enum('in_status_approve', ['OT'])->nullable()->comment('OT=On Time');
            $table->foreignId('in_status_approve_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('out_status_approve', ['LT'])->nullable()->comment('LT=Left Timely');
            $table->foreignId('out_status_approve_by')->nullable()->constrained('users')->cascadeOnDelete();

            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index(['company_id', 'branch_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
