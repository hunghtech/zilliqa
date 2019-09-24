<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateZilliqaBackendLendingPackage extends Migration
{
    public function up()
    {
        Schema::create('zilliqa_backend_lending_package', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('rate');
            $table->string('bonus_zil');
            $table->string('zil_address');
            $table->string('qr_code');
            $table->string('content');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('zilliqa_backend_lending_package');
    }
}
