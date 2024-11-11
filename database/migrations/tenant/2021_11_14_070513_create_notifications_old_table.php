<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsOldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['notification', 'message'])->comment('notification: notification, message: message')->default('notification');
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'company_id', 'branch_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications_old');
    }
}
