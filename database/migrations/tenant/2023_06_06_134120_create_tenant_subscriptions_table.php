<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subscription_id_in_main_company')->nullable();
            $table->string('invoice_no');
            $table->string('plan_name')->nullable();
            $table->decimal('price')->nullable()->default(0);
            $table->string('payment_gateway')->nullable();
            $table->string('trx_id')->nullable();
            $table->json('offline_payment')->nullable();
            $table->unsignedBigInteger('employee_limit')->nullable()->default(0);
            $table->tinyInteger('is_employee_limit')->default(1)->comment('if 1 then employee create have some limit which is define in employee_limit column. If 0 then employee create have no limit.');
            $table->date('expiry_date')->nullable();
            $table->json('features');
            $table->json('features_key');
            $table->tinyInteger('is_demo_checkout')->default(0);
            $table->enum('source', ['Website', 'Admin'])->nullable()->default('Website');
            $table->foreignId('status_id')->default(1)->comment('1=Active,2=Pending,4=inactive,5=Approve,6=Reject')->constrained('statuses');
            $table->foreignId('payment_status_id')->comment('8=Paid,9=Unpaid')->constrained('statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_subscriptions');
    }
}
