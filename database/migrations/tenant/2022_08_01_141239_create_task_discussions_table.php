<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_discussions', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->longText('description');
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('show_to_customer')->index('show_to_customer')->default(22)->constrained('statuses')->comment('22=No,32=Yes');
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses')->comment('1=active,4=inactive');
            $table->foreignId('file_id')->nullable()->comment('this will be attachment file')->constrained('uploads');
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'status_id', 'company_id', 'branch_id', 'user_id', 'task_id'], 'task_discussions_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_discussions');
    }
}
