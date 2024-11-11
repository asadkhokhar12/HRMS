<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('award_type_id')->constrained('award_types')->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->string('gift')->nullable();
            $table->double('amount', 16, 2)->nullable();
            $table->string('gift_info')->nullable();
            $table->longText('description');
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses')->comment('1=active,4=inactive');
            $table->foreignId('attachment')->nullable()->constrained('uploads');
            // goal
            $table->foreignId('goal_id')->nullable()->constrained('goals')->cascadeOnDelete();
            $table->timestamps();
            $table->index([ 'award_type_id', 'status_id', 'user_id']);

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
        Schema::dropIfExists('awards');
    }
}
