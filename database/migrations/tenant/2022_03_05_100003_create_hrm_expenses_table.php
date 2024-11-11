<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrmExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // expense table
        Schema::create('hrm_expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('income_expense_category_id')->constrained('income_expense_categories')->cascadeOnDelete();

            $table->date('date')->nullable()->comment('date of expense');
            $table->string('remarks', 191)->nullable()->comment('remarks of expense');
            $table->double('amount', 10, 2)->nullable()->comment('amount of expense');

            $table->foreignId('attachment_file_id')->nullable()->constrained('uploads')->cascadeOnDelete();
            $table->foreignId('status_id')->index('status_id')->default(1)->constrained('statuses');

            $table->foreignId('is_claimed_status_id')->index('claimed_status_id')->constrained('statuses');
            $table->foreignId('claimed_approved_status_id')->index('claimed_approved_status_id')->constrained('statuses');

            $table->softDeletes();
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
        Schema::dropIfExists('hrm_expenses');
    }
}
