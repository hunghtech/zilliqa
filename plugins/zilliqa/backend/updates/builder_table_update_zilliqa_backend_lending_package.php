<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateZilliqaBackendLendingPackage extends Migration
{
    public function up()
    {
        Schema::table('zilliqa_backend_lending_package', function($table)
        {
            $table->boolean('is_update_lending');
        });
    }
    
    public function down()
    {
        Schema::table('zilliqa_backend_lending_package', function($table)
        {
            $table->dropColumn('is_update_lending');
        });
    }
}
