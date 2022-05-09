<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyWebhookCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webhook_calls', function(Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->renameColumn('name', 'event');
            $table->renameColumn('payload', 'payload_id');
            $table->double('amount (cent)', 15, 8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn('user_id');
        $table->dropColumn('amount (cent)');
    }
}
