<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', '_token')) {
                    $table->text('_token')->nullable();
                }
                if (!Schema::hasColumn('users', 'app_token')) {
                    $table->text('app_token')->nullable();
                }
                if (!Schema::hasColumn('users', 'device_id')) {
                    $table->text('device_id')->nullable();
                }
                if (!Schema::hasColumn('users', 'device_info')) {
                    $table->text('device_info')->nullable()->comment('device name, device model, device board ');
                }
                if (!Schema::hasColumn('users', 'device_uuid')) {
                    $table->text('device_uuid')->nullable();
                }
                if (!Schema::hasColumn('users', 'last_login_device')) {
                    $table->string('last_login_device')->nullable()->comment('web or mobile');
                }
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
