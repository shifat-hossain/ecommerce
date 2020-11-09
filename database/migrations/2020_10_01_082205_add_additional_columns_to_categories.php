<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToCategories extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('categories', function (Blueprint $table) {
            $table->string("slug", 255)->after('category_name');
            $table->text('category_description')->nullable()->after('slug');
            $table->text('category_cover_image')->after('category_description');
            $table->text('category_thumbnail')->after('category_cover_image');
            $table->text('category_menu_image')->after('category_thumbnail');
            $table->string('meta_title')->nullable()->after('category_menu_image');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('categories', function (Blueprint $table) {
       $table->dropColumn('slug');
       $table->dropColumn('category_description');
       $table->dropColumn('category_cover_image');
       $table->dropColumn('category_thumbnail');
       $table->dropColumn('category_menu_image');
       $table->dropColumn('meta_title');
       $table->dropColumn('meta_description');
       $table->dropColumn('meta_keywords');
        });
    }

}
