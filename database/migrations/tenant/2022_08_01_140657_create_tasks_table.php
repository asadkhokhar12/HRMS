<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->date('date')->nullable();
            //progressBar
            $table->integer('progress')->nullable()->default(0);
            $table->foreignId('status_id')->index('status_id')->default(24)->constrained('statuses')->comment('24 = Not Started , 25 = On Hold', '26 = In Progress', '27 = Completed', '28 = Cancelled');
            $table->foreignId('priority')->index('priority')->default(24)->constrained('statuses')->comment('31 = Urgent , 30 = High', '29 = Medium', '28 = Low');
            $table->longText('description');
            //start_date
            $table->date('start_date');
            $table->date('end_date');

            $table->foreignId('created_by')->index('created_by')->default(1)->constrained('users');

            // notifying all users when project is created
            $table->tinyInteger('notify_all_users')->default(0)->comment('0=no,1=yes');

            // notifying all users via email when project is created

            $table->tinyInteger('notify_all_users_email')->default(0)->comment('0=no,1=yes');
            // task type
            $table->tinyInteger('type')->default(0)->comment('0=Regular , 1= Project');

            $table->foreignId('project_id')->nullable()->index('project_id')->constrained('projects')->cascadeOnDelete();

            $table->tinyInteger('reminder')->default(0)->comment('0=no,1=yes');
            // goal
            $table->foreignId('goal_id')->nullable()->constrained('goals')->cascadeOnDelete();
            $table->unsignedBigInteger('service_id')->nullable();

            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index(['company_id', 'branch_id', 'priority', 'status_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
