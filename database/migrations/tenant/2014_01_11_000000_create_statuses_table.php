<?php

use App\Models\coreApp\Status\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->index()->comment('hare name=status situation');
            $table->string('class', 50)->index()->nullable()->comment('hare class=what type of class name property like success,danger,info,purple');
            $table->string('color_code')->nullable(); 
            $table->timestamps(); 
            $table->index(['name', 'class']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
