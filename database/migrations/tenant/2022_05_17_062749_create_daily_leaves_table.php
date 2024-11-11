<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('approved_by_tl')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('approved_at_tl')->nullable();

            $table->foreignId('approved_by_hr')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('approved_at_hr')->nullable();

            $table->foreignId('rejected_by_tl')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('rejected_at_tl')->nullable();

            $table->foreignId('rejected_by_hr')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('rejected_at_hr')->nullable();

            $table->enum('leave_type', ['early_leave', 'late_arrive'])->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->text('reason')->nullable();
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses');
            $table->foreignId('author_info_id')->nullable()->constrained('author_infos');
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
        Schema::dropIfExists('daily_leaves');
    }
}
