<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->foreignId('check_in_image')->nullable()->constrained('uploads')->onDelete('cascade')->after('face_image');
                $table->foreignId('check_out_image')->nullable()->constrained('uploads')->onDelete('cascade')->after('face_image');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['check_in_image']);
            $table->dropForeign(['check_out_image']);
            $table->dropColumn(['check_in_image', 'check_out_image']);
        });
    }
};
