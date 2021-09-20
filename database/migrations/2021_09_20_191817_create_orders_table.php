<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->bigInteger('customer_id')->default(null)->nullable();
            $table->bigInteger('category_id')->default(null)->nullable();
            $table->string('jewellery_name')->default(null)->nullable();
            $table->longText('description')->default(null)->nullable();
            $table->string('design_image')->default(null)->nullable();
            $table->float('weight')->default(0)->nullable();
            $table->double('current_rate')->default(0)->nullable();
            $table->double('making_charge')->default(0)->nullable();
            $table->double('other_charge')->default(0)->nullable();
            $table->double('total_cost')->default(0)->nullable();
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
}
