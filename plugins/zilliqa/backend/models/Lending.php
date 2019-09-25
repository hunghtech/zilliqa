<?php namespace Zilliqa\Backend\Models;

use Model;

/**
 * Model
 */
class Lending extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_lending_package';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
