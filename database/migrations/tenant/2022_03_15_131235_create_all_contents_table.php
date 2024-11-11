<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_contents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->default(1)->constrained('users')->cascadeOnDelete();

            $table->string('type', 50);
            $table->string('title');
            $table->string('slug');
            $table->longtext('content');
            $table->text('meta_title');
            $table->string('meta_description', 1000)->nullable();
            $table->string('keywords', 1000)->nullable();
            $table->string('meta_image')->nullable();

            $table->unsignedBigInteger('created_by')->default(1)->nullable();
            $table->unsignedBigInteger('updated_by')->default(1)->nullable();

            $table->foreignId('status_id')->default(1)->constrained('statuses');

            $table->timestamps();

            // database table index create
            $table->index(['type', 'title', 'slug']);

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
        Schema::dropIfExists('all_contents');
    }
}
