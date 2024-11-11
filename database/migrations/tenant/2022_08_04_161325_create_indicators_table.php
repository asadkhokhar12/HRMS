<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->nullable()->constrained('departments')->cascadeOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->cascadeOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained('designations')->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->json('rates')->nullable();

            $table->float('rating')->nullable();
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->foreignId('status_id')->nullable()->default(1)->constrained('statuses');
            $table->index([ 'status_id', 'company_id', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicators');
    }
}
