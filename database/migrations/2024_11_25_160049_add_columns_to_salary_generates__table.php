<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_generates', function (Blueprint $table) {
            $table->double('tax')->after('adjust')->default(0.0);
            $table->double('late_deductions_amount')->after('tax')->default(0.0);
            $table->double('half_day_deductions_amount')->after('late_deductions_amount')->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_generates_', function (Blueprint $table) {
            //
        });
    }
};
