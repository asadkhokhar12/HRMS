<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('expire_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id')->comment('it will come from user table');
            $table->unsignedBigInteger('employee_id')->comment('it will come from user table');
            $table->unsignedBigInteger('branch_id')->default(1);
            $table->unsignedBigInteger('company_id')->default(1);
            $table->string('title');
            $table->string('description')->nullable();
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expire_notifications');
    }
};
