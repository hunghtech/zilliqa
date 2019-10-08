<?php namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use JWTAuth;

/**
 * Model
 */
class HistoryDaily extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_history_daily';
    
    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'daily'];

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
        'user' => ['RainLab\User\Models\User', 'key' => 'user_id']
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
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFilter($request) {
        $perPage = $request->get('limit', 10);

        $user = JWTAuth::parseToken()->authenticate();
        $userID = $user->id;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $dailyModel = $this->where('id', '>', 0);
        $dailyModel->when($userID, function($query, $userID) {
            return $query->where('user_id', $userID);
        });

        $dailyModel->when($fromDate, function($query, $fromDate) {
            return $query->whereDate('created_at', '>=', $fromDate);
        });

        $dailyModel->when($toDate, function($query, $toDate) {
            return $query->whereDate('created_at', '<=', $toDate);
        });

        $dailyModel->orderBy('id', 'desc');

        $result = $dailyModel->paginate($perPage)->toArray();

        return $result;
    }
}
