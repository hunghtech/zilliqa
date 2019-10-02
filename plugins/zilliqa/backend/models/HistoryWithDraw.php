<?php

namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use JWTAuth;

/**
 * Model
 */
class HistoryWithDraw extends Model {

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_history_with_draw';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'coint', 'amount', 'status', 'type'];

    /**
     * @var array Validation rules
     */
    public $rules = [];

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

    public function afterSave() {
        if ($this->status == 2) {
            $user = User::find($this->user_id);
            $amount = $this->amount;
            if ($user) {
                if ($this->type == 1) {
                    $user->zilliqa = $user->zilliqa - $amount;
                    $user->zilliqa_minimum = $user->zilliqa_minimum - $amount;
                } elseif ($this->type == 2) {
                    $user->daily = $user->daily - $amount;                    
                } else {
                    $user->commission = $user->commission - $amount;                    
                }
                $user->save();
            }
        }
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
        $type = $request->type;

        $depositModel = $this->where('id', '>', 0);
        $depositModel->when($userID, function($query, $userID) {
            return $query->where('user_id', $userID);
        });

        $depositModel->when($type, function($query, $type) {
            return $query->where('type', $type);
        });


        $depositModel->when($fromDate, function($query, $fromDate) {
            return $query->whereDate('created_at', '>=', $fromDate);
        });

        $depositModel->when($toDate, function($query, $toDate) {
            return $query->whereDate('created_at', '<=', $toDate);
        });

        $depositModel->orderBy('id', 'desc');

        $result = $depositModel->paginate($perPage)->toArray();

        return $result;
    }

}
