<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',100)->default(null)->nullable();
            $table->string('last_name',100)->default(null)->nullable();
            $table->string('village_name',150)->default(null)->nullable();
            $table->string('phone_number',20)->default(null)->nullable();
            $table->string('alternate_phone_number',20)->default(null)->nullable();
            $table->string('email',150)->default(null)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->longText('address')->default(null)->nullable();
            $table->longText('description')->default(null)->nullable();
            $table->string('profile_image')->default(null)->nullable();
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
        Schema::dropIfExists('users');
    }
}
