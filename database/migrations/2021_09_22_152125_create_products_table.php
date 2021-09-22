<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->default(null)->nullable();
            $table->bigInteger('category_id')->default(null)->nullable();
            $table->longText('description')->default(null)->nullable();
            $table->string('qr_code')->default(null)->nullable();
            $table->string('qr_code_image')->default(null)->nullable();
            $table->tinyInteger('is_active')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
