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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('consigner_id');
            $table->string('code')->unique();
            $table->decimal('sub_total');
            $table->decimal('consigner_fee');
            $table->decimal('total');
            $table->string('destination')->nullable();
            $table->string('destination_name')->nullable();
            $table->string('status')->default('pending'); //in transit, delivered, at checkpoint, lost
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
        Schema::dropIfExists('orders');
    }
};
