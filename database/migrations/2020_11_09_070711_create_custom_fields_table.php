<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_section', 55);
            $table->string('field_type', 55);
            $table->string('field_key', 25);
            $table->string('field_label', 25);
            $table->string('field_validation', 25);
            $table->string('field_default_value', 25)->nullable();
            $table->bigInteger('field_created_by');
            $table->string('field_in_list', 10);
            $table->string('field_status', 10)->default('ACTIVE');
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
        Schema::dropIfExists('custom_fields');
    }
}
