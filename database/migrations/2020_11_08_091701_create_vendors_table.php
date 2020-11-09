<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_id', 100);
            $table->string('vendor_type', 255)->nullable();
            $table->string('vendor_name', 55);
            $table->string('vendor_email', 255)->nullable();
            $table->string('vendor_phone', 25);
            $table->bigInteger('country_id')->nullable();
            $table->text('country_name')->nullable();
            $table->integer('state_id')->nullable();
            $table->text('state_name')->nullable();
            $table->string('vendor_nid', 55)->nullable();
            $table->text('vendor_address')->nullable();
            $table->bigInteger('vendor_created_by');
            $table->string('vendor_status', 55);
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
        Schema::dropIfExists('vendors');
    }
}
