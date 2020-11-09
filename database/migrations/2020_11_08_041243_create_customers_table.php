<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code', 100);
            $table->string('customer_first_name', 55);
            $table->string('customer_last_name', 55);
            $table->string('customer_email', 255);
            $table->string('password');
            $table->string('customer_phone', 25);
            $table->bigInteger('country_id')->nullable();
            $table->text('country_name')->nullable();
            $table->integer('state_id')->nullable();
            $table->text('state_name')->nullable();
            $table->string('customer_postal_code', 55)->nullable();
            $table->text('customer_address')->nullable();
            $table->string('customer_status', 55);
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
        Schema::dropIfExists('customers');
    }
}
