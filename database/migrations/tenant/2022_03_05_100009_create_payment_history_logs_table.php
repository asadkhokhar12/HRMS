<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_history_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('payment_history_id')->constrained('payment_histories')->cascadeOnDelete();
            $table->foreignId('expense_claim_id')->constrained('expense_claims')->cascadeOnDelete();

            $table->double('payable_amount', 10, 2)->nullable()->comment('amount of payment');
            $table->double('paid_amount', 10, 2)->nullable()->comment('paid amount of payment');
            $table->double('due_amount', 10, 2)->nullable()->comment('due amount of payment');
            $table->date('date')->nullable();

            $table->foreignId('paid_by_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index([ 'date', 'paid_by_id', 'company_id', 'branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_history_logs');
    }
}
