<?php namespace Zilliqa\Backend\Models;

use Model;

/**
 * Model
 */
class Presenter extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_presenter';
    
     /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'user_present'];
    protected $hidden = ['updated_at'];


    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
