<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competence_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses')->comment('1=Active,4=Inactive');
            $table->unsignedBigInteger('created_by')->nullable()->default(1);
            $table->unsignedBigInteger('updated_by')->nullable()->default(1);
            $table->timestamps();
            $table->index([ 'status_id']);

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
        Schema::dropIfExists('competence_types');
    }
}
