<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('leave_types')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            
            $table->integer('leave_days');
            $table->integer('leave_available');
            $table->integer('leave_used');
            $table->integer('year');
            
            $table->foreignId('status_id')->constrained('statuses');
            $table->timestamps();

            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1); 
            $table->index(['company_id','branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_years');
    }
};
