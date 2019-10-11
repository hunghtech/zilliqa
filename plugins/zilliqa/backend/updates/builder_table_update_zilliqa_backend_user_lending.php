<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateZilliqaBackendUserLending extends Migration
{
    public function up()
    {
        Schema::table('zilliqa_backend_user_lending', function($table)
        {
            $table->boolean('is_update_lending');
        });
    }
    
    public function down()
    {
        Schema::table('zilliqa_backend_user_lending', function($table)
        {
            $table->dropColumn('is_update_lending');
        });
    }
}
