<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateZilliqaBackendHistoryWithDraw2 extends Migration
{
    public function up()
    {
        Schema::table('zilliqa_backend_history_with_draw', function($table)
        {
            $table->double('eth_convert', 10, 0);
            $table->string('wallet_address');
        });
    }
    
    public function down()
    {
        Schema::table('zilliqa_backend_history_with_draw', function($table)
        {
            $table->dropColumn('eth_convert');
            $table->dropColumn('wallet_address');
        });
    }
}
