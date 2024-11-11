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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_title', 255)->nullable();
            $table->string('document_number')->nullable();
            $table->date('document_expiration')->nullable();

            $table->text('document_request_description')->nullable();
            $table->boolean('document_request_approved')->nullable();
            $table->date('document_request_date')->nullable();
            $table->date('document_notification_date')->nullable();

            $table->foreignId('attachment_id')->nullable()->constrained('uploads');
            // Relations
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('user_document_type_id')->constrained('user_document_types');

            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index(['id', 'user_id', 'user_document_type_id', 'document_number', 'document_expiration', 'company_id', 'branch_id'], 'user_documents_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_documents');
    }
};
