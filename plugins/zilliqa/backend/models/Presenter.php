<?php namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;

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
    public $rules = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    protected $appends = ['user', 'user_referal'];

    /**
     * @return mixed
     */
    public function getUserAttribute() {
        $users = User::where('id', $this->user_id)->get()->toArray();
        return $users;
    }

    /**
     * @return mixed
     */
    public function getUserReferalAttribute() {
        $users = User::where('id', $this->user_present)->get()->toArray();
        return $users;
    }
    
    public static function getReferralLevel($user_id){
        return self::where('user_present',$user_id)->count();
    }
    
    public static function getCommissionReferralLevel($user_id){
        return self::where('user_present',$user_id)->count();
    }
}
