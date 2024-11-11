<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_infos', function (Blueprint $table) {
            $table->id();
            $table->morphs('authorable');
            // created by
            $table->foreignId('created_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            // updated by
            $table->foreignId('updated_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            // approved by
            $table->foreignId('approved_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('approved_at')->nullable();
            // rejected by
            $table->foreignId('rejected_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('rejected_at')->nullable();
            // cancelled by
            $table->foreignId('cancelled_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('cancelled_at')->nullable();
            // published by
            $table->foreignId('published_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('published_at')->nullable();
            // unpublished by
            $table->foreignId('unpublished_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('unpublished_at')->nullable();
            // deleted by
            $table->foreignId('deleted_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('deleted_at')->nullable();
            // archived by
            $table->foreignId('archived_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('archived_at')->nullable();
            // archived by
            $table->foreignId('restored_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('restored_at')->nullable();
            // referred by
            $table->foreignId('referred_by')->nullable()->default(null)->constrained('users')->cascadeOnDelete();
            $table->timestamp('referred_at')->nullable();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index(['company_id', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('author_infos');
    }
}
