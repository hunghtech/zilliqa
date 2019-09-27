<?php namespace Zilliqa\Backend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateZilliqaBackendCountries extends Migration
{
    public function up()
    {
        Schema::create('zilliqa_backend_countries', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('country_code');
            $table->string('name');
            $table->string('phonecode');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('zilliqa_backend_countries');
    }
}
