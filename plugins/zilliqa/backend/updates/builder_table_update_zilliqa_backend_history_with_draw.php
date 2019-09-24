<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateZilliqaBackendHistoryWithDraw extends Migration
{
    public function up()
    {
        Schema::table('zilliqa_backend_history_with_draw', function($table)
        {
            $table->integer('type');
        });
    }
    
    public function down()
    {
        Schema::table('zilliqa_backend_history_with_draw', function($table)
        {
            $table->dropColumn('type');
        });
    }
}
