<?php namespace Zilliqa\Backend\Models;

use Model;
use Zilliqa\Backend\Models\Lending;
use RainLab\User\Models\User;

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
     * @var array Fillable fields
     */
    protected $fillable = ['user_id','status', 'lending_id','is_update_lending'];

    /**
     * @var array Validation rules
     */
    public $rules = [];
    
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'user' => ['RainLab\User\Models\User', 'key' => 'user_id'],
        'lending' => ['Zilliqa\Backend\Models\Lending', 'key' => 'lending_id']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    
    public function getUserIdOptions() {
        $users = User::lists('name', 'id');
        return $users;
    }
    
    public function getLendingIdOptions() {
        $lendings = Lending::lists('title', 'id');
        return $lendings;
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserLendings($user_id) {
        $list = $this->where('status',1)->where('user_id',$user_id)->get();
        if($list){
            $businessVolume = 0;
            foreach($list as $item){
                $lendingID = $item->lending_id;
                $lending = Lending::find($lendingID);
                $businessVolume += $lending->title;
            }
            return $businessVolume;
        }
        return false;
    }
}
