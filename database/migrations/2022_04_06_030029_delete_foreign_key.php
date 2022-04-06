<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign("stores_user_id_foreign");
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign("products_store_id_foreign");
            $table->dropForeign("products_category_id_foreign");
        });

        Schema::table('profile', function (Blueprint $table) {
            $table->dropForeign("profile_user_id_foreign");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
