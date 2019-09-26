<?php namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;


/**
 * Model
 */
class HistoryDeposit extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_history_deposit';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = ['user' => ['RainLab\User\Models\User', 'key' => 'user_id']];
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
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFilter(Request $request)
    {
        $perPage = $request->get('limit', 10);
        
        //Initialize param for product filter
        $userID = $request->user_id;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $depositModel = $this->whereNull('deleted_at');
        $depositModel->when($userID, function($query, $userID) {
            return $query->where('user_id', $userID);
        });
        $depositModel->when($fromDate, $toDate, function($query, $fromDate, $toDate) {
            return $query->whereBetween('reservation_from', [$fromDate, $toDate]);
        });
                       
        $depositModel->orderBy('id', 'desc');

        $result = $depositModel->paginate($perPage)->toArray();

        return $result;
    }
}
