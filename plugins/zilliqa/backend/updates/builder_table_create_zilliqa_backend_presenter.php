<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateZilliqaBackendPresenter extends Migration
{
    public function up()
    {
        Schema::create('zilliqa_backend_presenter', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->integer('user_present');
            $table->integer('parent_present');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('zilliqa_backend_presenter');
    }
}
