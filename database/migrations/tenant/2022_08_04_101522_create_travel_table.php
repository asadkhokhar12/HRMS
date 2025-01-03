<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('travel_type_id')->constrained('travel_types')->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses')->comment('1=active,4=inactive');
            $table->double('expect_amount', 16, 2)->nullable();
            $table->double('amount', 16, 2)->nullable();
            $table->longText('description');
            $table->foreignId('attachment')->nullable()->constrained('uploads');
            $table->string('purpose')->nullable();
            $table->string('place')->nullable();
            $table->enum('mode', ['bus', 'train', 'plane'])->nullable();
            $table->foreignId('goal_id')->nullable()->constrained('goals')->cascadeOnDelete();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'travel_type_id', 'company_id', 'status_id', 'user_id', 'branch_id'], 'travel_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel');
    }
}
