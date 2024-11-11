<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekends', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->enum('name', ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday']);
            $table->integer('order')->nullable();
            $table->enum('is_weekend', ['yes', 'no'])->default('no')->nullable();

            $table->foreignId('status_id')->constrained('statuses')->cascadeOnDelete();
            $table->unsignedBigInteger('created_by')->nullable()->default(1);
            $table->unsignedBigInteger('updated_by')->nullable()->default(1);
            $table->timestamps();


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
        Schema::dropIfExists('weekends');
    }
}
