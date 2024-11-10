<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index('user_id')->default(1)->constrained('users');

            $table->foreignId('income_expense_category_id')->constrained('income_expense_categories')->cascadeOnDelete(); 
            $table->date('date');
            $table->double('amount', 16, 2)->nullable();
            $table->double('request_amount', 16, 2)->default(0);

            $table->string('ref', 200)->nullable();

            $table->foreignId('payment_method_id')->nullable()->index('payment_method_id')->constrained('payment_methods');

            $table->foreignId('transaction_id')->nullable()->index('transaction_id')->constrained('transactions');

            $table->foreignId('pay')->index('pay')->default(9)->constrained('statuses')->comment('9=Unpaid, 8=Paid');

            $table->foreignId('status_id')->index('status_id')->default(2)->constrained('statuses')->comment('1= Active, 2=Pending, 5=Approved, 6=Rejected');

            $table->foreignId('approver_id')->nullable()->index('approver_id')->constrained('users');
            $table->text('remarks')->nullable();

            $table->foreignId('created_by')->index('created_by')->default(1)->constrained('users');
            $table->foreignId('updated_by')->index('updated_by')->default(1)->constrained('users');

            $table->foreignId('attachment')->nullable()->constrained('uploads')->cascadeOnDelete();

            $table->timestamps();

            $table->index([ 'amount', 'date']);

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
        Schema::dropIfExists('deposits');
    }
}
