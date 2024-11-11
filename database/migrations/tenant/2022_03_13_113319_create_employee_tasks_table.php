<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_id')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->date('due_date')->nullable();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();

            $table->foreignId('attachment_file_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses');

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
        Schema::dropIfExists('employee_tasks');
    }
}
