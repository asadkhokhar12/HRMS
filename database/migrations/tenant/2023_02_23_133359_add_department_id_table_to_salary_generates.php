<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentIdTableToSalaryGenerates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_generates', function (Blueprint $table) {
            
            if (!Schema::hasColumn('salary_generates', 'department_id')) {
                $table->integer('department_id')->nullable();
            }
        });
        Schema::table('commissions', function (Blueprint $table) {
            if (!Schema::hasColumn('commissions', 'amount')) {
                $table->double('amount')->default(0);
            }
            if (!Schema::hasColumn('commissions', 'mode')) {
                $table->integer('mode')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_generates', function (Blueprint $table) {
            //
        });
    }
}
