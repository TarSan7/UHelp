<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundraisingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fundraisings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('info');
            $table->text('short_info');
            $table->foreignId('user_id');
            $table->date('start_date');
            $table->float('sum');
            $table->float('remaining_amount');
            $table->boolean('is_active')->default(0);
            $table->string('cause', 256);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fundraisings');
    }
}
