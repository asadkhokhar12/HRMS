<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('expense_claim_id')->constrained('expense_claims')->cascadeOnDelete();

            $table->string('code', 191)->unique()->nullable()->comment('invoice number');
            $table->date('payment_date')->nullable()->comment('date of payment');

            $table->string('remarks', 191)->nullable()->comment('remarks of payment');

            $table->double('payable_amount', 10, 2)->nullable()->comment('amount of payment');
            $table->double('paid_amount', 10, 2)->nullable()->comment('paid amount of payment');
            $table->double('due_amount', 10, 2)->nullable()->comment('due amount of payment');

            $table->foreignId('attachment_file_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('payment_status_id')->index('status_id')->constrained('statuses');

            $table->timestamps();

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index(['payment_date', 'payment_status_id', 'company_id', 'branch_id'], 'payment_histories_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_histories');
    }
}
