<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('invoice')->nullable();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->date('date')->nullable();
            //progressBar
            $table->integer('progress_from_tasks')->nullable()->default(1);
            $table->integer('progress')->nullable()->default(0);
            //billing_type enums
            $table->enum('billing_type', ['hourly', 'fixed'])->nullable();
            $table->double('per_rate', 16, 2)->nullable();
            $table->double('total_rate', 16, 2)->nullable();
            $table->double('estimated_hour', 16, 2)->nullable();
            $table->foreignId('status_id')->index('status_id')->default(24)->constrained('statuses')->comment('24 = Not Started , 25 = On Hold', '26 = In Progress', '27 = Completed', '28 = Cancelled');
            $table->foreignId('priority')->index('priority')->default(24)->constrained('statuses')->comment('31 = Urgent , 30 = High', '29 = Medium', '28 = Low');
            $table->longText('description');
            //start_date
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('payment')->index('payment')->default(9)->constrained('statuses')->comment('9=Unpaid, 8=Paid', '20 = Partial Paid');
            $table->double('amount', 16, 2)->nullable();
            $table->double('paid', 16, 2)->default(0.00);
            $table->double('due', 16, 2)->default(0.00);
            $table->foreignId('created_by')->index('created_by')->default(1)->constrained('users');
            // notifying all users when project is created
            $table->tinyInteger('notify_all_users')->default(0)->comment('0=no,1=yes');
            // notifying all users via email when project is created
            $table->tinyInteger('notify_all_users_email')->default(0)->comment('0=no,1=yes');
            $table->foreignId('goal_id')->nullable()->constrained('goals')->cascadeOnDelete();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'client_id', 'status_id', 'priority', 'start_date','end_date', 'company_id', 'branch_id'], 'projects_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
