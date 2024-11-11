<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('user_document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 91)->unique();
            $table->bigInteger('status_id')->default(1)->comment('1=active,4=inactive');
            $table->timestamps();
            $table->index('name');

            //modified on 10 Nov 2023
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            $table->unsignedBigInteger('branch_id')->nullable()->default(1);
            $table->index(['id', 'name', 'status_id', 'company_id', 'branch_id']);
        });
        $documentTypes = [
            "Resume/CV",
            "Job Offer Letter",
            "Employment Contract",
            "W-4 Form",
            "I-9 Form",
            "Payroll Records",
            "Employee Handbook",
            "Passport",
            "Social Security Number (SSN)",
            "Work Authorization",
        ];

        foreach ($documentTypes as $type) {
            DB::table('user_document_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_document_types');
    }
};
