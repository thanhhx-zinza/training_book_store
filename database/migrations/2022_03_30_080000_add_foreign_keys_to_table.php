<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->foreignId('user_id')->references('id')->on('users');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('store_id')->references('id')->on('stores');
            $table->foreignId('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign('users_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('stores_store_id_foreign');
            $table->dropColumn('store_id');
            $table->dropForeign('categories_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
