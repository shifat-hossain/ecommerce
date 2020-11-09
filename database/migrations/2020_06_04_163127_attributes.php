<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Attributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes_group', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_group_name', 100);          
            $table->timestamps();
        });
        
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_group_id')->constrained('attributes_group')->onDelete('cascade');
            $table->string('attribute_name', 100);
              $table->string('color_code', 100)->nullable();
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
        Schema::dropIfExists('attributes_group');
        Schema::drop('attributes');
    }
}
