<?php namespace Zilliqa\Backend\Models;

use Model;

/**
 * Model
 */
class UserLending extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_user_lending';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
