<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_leaves', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('type_id')->constrained('leave_types')->cascadeOnDelete();
            $table->integer('days');
            $table->foreignId('status_id')->constrained('statuses');
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            // add soft deletes
            $table->softDeletes();
            $table->index([ 'type_id',  'status_id']);


            //modified on 10 Nov 2023
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
        Schema::dropIfExists('assign_leaves');
    }
}
