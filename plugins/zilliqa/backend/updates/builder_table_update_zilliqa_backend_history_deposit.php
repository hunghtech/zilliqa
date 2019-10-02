<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateZilliqaBackendHistoryDeposit extends Migration
{
    public function up()
    {
        Schema::table('zilliqa_backend_history_deposit', function($table)
        {
            $table->integer('lending_id');
        });
    }
    
    public function down()
    {
        Schema::table('zilliqa_backend_history_deposit', function($table)
        {
            $table->dropColumn('lending_id');
        });
    }
}
