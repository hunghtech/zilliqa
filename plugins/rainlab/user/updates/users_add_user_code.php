<?php namespace RainLab\User\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UsersAddUserCode extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('user_code')->nullable();
            $table->string('zil_address')->nullable();
            $table->string('eth_adress')->nullable();
            $table->integer('daily');
            $table->integer('commission');
            $table->integer('lending');
            $table->integer('zlliqa');
            $table->integer('downline_member');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'user_code')) {
            Schema::table('users', function($table)
            {
                $table->dropColumn('user_code');
                $table->dropColumn('zil_address');
                $table->dropColumn('eth_adress');
                $table->dropColumn('daily');
                $table->dropColumn('commission');
                $table->dropColumn('lending');
                $table->dropColumn('zlliqa');
                $table->dropColumn('downline_member');
            });
        }
    }
}
