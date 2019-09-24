<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateZilliqaBackendHistoryWithDraw extends Migration
{
    public function up()
    {
        Schema::create('zilliqa_backend_history_with_draw', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->string('coint');
            $table->double('amount', 10, 0);
            $table->integer('status');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('zilliqa_backend_history_with_draw');
    }
}
