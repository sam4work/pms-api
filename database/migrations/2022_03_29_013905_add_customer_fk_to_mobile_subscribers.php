<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_subscribers', function (Blueprint $table) {
            //
            $table->foreign(
                "customer_id_owner"
            )->references('id')->on('customers');

            $table->foreign(
                "customer_id_user"
            )->references('id')->on('customers');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_subscribers', function (Blueprint $table) {
            //
            $table->dropForeign([
                "customer_id_owner"]);
            $table->dropForeign([
                "customer_id_user"]);
        });
    }
};
