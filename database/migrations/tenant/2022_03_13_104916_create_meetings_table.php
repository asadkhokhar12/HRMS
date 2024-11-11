<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('location')->nullable();
            $table->string('duration')->nullable();
            $table->date('date')->nullable();
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();
            $table->foreignId('attachment_file_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->text('image_url')->nullable();
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
        Schema::dropIfExists('meetings');
    }
}
