<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_setups', function (Blueprint $table) {
            $table->id();
            $table->string('host_name')->nullable();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses');
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
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
        Schema::dropIfExists('meeting_setups');
    }
}
