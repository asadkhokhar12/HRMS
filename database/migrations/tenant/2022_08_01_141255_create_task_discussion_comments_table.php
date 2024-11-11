<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDiscussionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_discussion_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->longText('description');
            $table->tinyInteger('show_to_customer')->default(1)->comment('0=no,1=yes');
            $table->foreignId('task_discussion_id')->constrained('task_discussions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('attachment')->nullable()->constrained('uploads');
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'task_discussion_id', 'company_id', 'branch_id', 'comment_id', 'user_id'], 'task_discussion_comments_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_discussion_comments');
    }
}
