<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('consigner_id');
            $table->bigInteger('courier_id')->nullable();
            $table->bigInteger('order_id');
            $table->bigInteger('next_point_id')->nullable();
            $table->string('reference')->nullable();
            $table->string('origin');
            $table->string('destination');
            $table->string('current_position');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('shipments');
    }
};
