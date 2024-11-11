<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191);
            $table->longText('value');
            $table->bigInteger('image_id')->nullable();
            $table->string('context', 191)->default('app')->nullable();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->foreignId('status_id')->nullable()->default(1)->constrained('statuses');
            $table->index(['name', 'context', 'status_id', 'company_id', 'branch_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting');
    }
}
