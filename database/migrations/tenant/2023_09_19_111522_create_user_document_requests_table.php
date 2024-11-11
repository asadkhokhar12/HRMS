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

        Schema::create('user_document_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id')->default(1);
            $table->unsignedBigInteger('company_id')->default(1);
            $table->string('request_type');
            $table->text('request_description')->nullable();
            $table->boolean('approved')->nullable();
            $table->date('request_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreignId('status_id')->constrained('statuses');

            // Add indexes for optimization
            $table->index('user_id');
            $table->index('request_type');
            $table->index('approved');
            $table->index('request_date');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_document_requests');
    }
};
