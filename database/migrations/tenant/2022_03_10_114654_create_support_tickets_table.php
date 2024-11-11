<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('code', 191);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('assigned_id')->nullable()->constrained('users');
            $table->foreignId('attachment_file_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->text('image_url')->nullable();
            $table->string('subject', 191)->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('status_id')->default(1)->constrained('statuses');
            $table->foreignId('type_id')->default(12)->comment('12 = open , 13 = close')->constrained('statuses');
            $table->foreignId('priority_id')->default(14)->comment('14 = high , 15 = medium , 16 = low')->constrained('statuses');
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'status_id', 'assigned_id', 'type_id', 'priority_id', 'company_id', 'branch_id'], 'support_tickets_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_tickets');
    }
}
