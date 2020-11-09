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
            $table->string('order_code', 100);
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('customer_name', 255);
            $table->string('order_status', 20);
            $table->double('order_total', 25, 2);
            $table->double('order_tax_percent', 3, 2);
            $table->double('order_tax_amount', 25, 2);
            $table->double('order_discount_amount', 25, 2);
            $table->double('order_sub_total', 25, 2);
            $table->double('order_grand_total', 25, 2);
            $table->date('order_date');
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
