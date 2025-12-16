<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vc_name');
            $table->string('vc_code')->unique();
            $table->text('vc_description')->nullable();
            $table->tinyInteger('vc_type')->default(1);
            $table->integer('vc_value')->default(0);
            $table->integer('vc_max_discount')->nullable();
            $table->integer('vc_quantity')->default(0);
            $table->integer('vc_used')->default(0);
            $table->tinyInteger('vc_status')->default(1);
            $table->dateTime('vc_started_at')->nullable();
            $table->dateTime('vc_ended_at')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
