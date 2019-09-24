<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateZilliqaBackendUserLending extends Migration
{
    public function up()
    {
        Schema::create('zilliqa_backend_user_lending', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('lending_id');
            $table->integer('status');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('zilliqa_backend_user_lending');
    }
}
