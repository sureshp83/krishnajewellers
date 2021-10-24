<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerLoanJewelleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_loan_jewelleries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id')->default(null)->nullable();
            $table->bigInteger('category_id')->default(null)->nullable();
            $table->string('jewellery_name')->default(null)->nullable();
            $table->longText('description')->default(null)->nullable();
            $table->double('weight',8,2)->default(0)->nullable();
            $table->double('current_rate',10,2)->default(0)->nullable();
            $table->double('total_cost',10,2)->default(0)->nullable();
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
        Schema::dropIfExists('customer_loan_jewelleries');
    }
}
