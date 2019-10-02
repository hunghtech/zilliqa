<?php

namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use Zilliqa\Backend\Models\Lending;
use JWTAuth;
use Zilliqa\Backend\Models\UserLending;

/**
 * Model
 */
class HistoryDeposit extends Model {

    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_history_deposit';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'coint', 'amount', 'status', 'lending_id'];

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
    
    public function afterSave() {
        if ($this->status == 2) {
            //Insert user Lending
            $arrData = [
                'user_id' => $this->user_id, 'lending_id' => $this->lending_id, 'status' => 1
            ];
            UserLending::create($arrData);
            //Check Lending Package
            $lending = Lending::find($this->lending_id);
            $bonusZil = $lending->bonus_zil;
            //Update Zill for user            
            if ($bonusZil > 0) {
                $user = User::find($this->user_id);
                if ($user) {
                    $zilliqa_minimum = $bonusZil/10;
                    $user->zilliqa = $user->zilliqa + $bonusZil;
                    $user->zilliqa_minimum = $user->zilliqa_minimum + $zilliqa_minimum;
                    $user->save();
                }
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFilter($request) {
        $perPage = $request->get('limit', 10);

        //Initialize param for product filter
        $user = JWTAuth::parseToken()->authenticate();
        $userID = $user->id;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $depositModel = $this->whereNull('deleted_at');
        $depositModel->when($userID, function($query, $userID) {
            return $query->where('user_id', $userID);
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
