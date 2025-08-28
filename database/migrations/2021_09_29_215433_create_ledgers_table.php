<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('group')->nullable();
            $table->string('dara')->nullable();
            $table->string('dara_commission')->nullable();
            $table->string('akhar')->nullable();
            $table->string('akhar_commission')->nullable();
            $table->string('tp')->nullable();
            $table->string('rebate')->nullable();
            $table->string('tp_r')->nullable();
            $table->string('hissa')->nullable();
            $table->string('grantor')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('ledgers');
    }
}
