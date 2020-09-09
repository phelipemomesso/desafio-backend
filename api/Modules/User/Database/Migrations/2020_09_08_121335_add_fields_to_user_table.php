<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_users', function (Blueprint $table) {
            $table->float('initial_amount', 15, 6)->default(0)->after('birthdate');
            $table->float('current_amount', 15, 6)->default(0)->after('initial_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_users', function (Blueprint $table) {
            $table->dropColumn(['initial_amount', 'current_amount']);
        });
    }
}
