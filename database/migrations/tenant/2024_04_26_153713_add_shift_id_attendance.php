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
         // Check if the column exists before adding it
         if (!Schema::hasColumn('attendances', 'shift_id')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->unsignedInteger('shift_id')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
