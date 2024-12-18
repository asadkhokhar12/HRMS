<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_activities', function (Blueprint $table) {
            $table->id();
            $table->longText('description');
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'task_id', 'user_id', 'company_id', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_activities');
    }
}
