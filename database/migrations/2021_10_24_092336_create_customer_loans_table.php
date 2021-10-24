<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_loans', function (Blueprint $table) {
            $table->id();
            $table->string('unique_loan_id',100)->default(null)->nullable();
            $table->bigInteger('customer_id')->default(null)->nullable();
            $table->double('total_jewellery_cost',10,2)->default(0);
            $table->double('loan_amount',10,2)->default(0);
            $table->float('interest',10,2)->default(0);
            $table->enum('status',['PENDING','CLOSED'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_loans');
    }
}
