<?php

namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use Zilliqa\Backend\Models\HistoryCommission;
use Zilliqa\Backend\Models\Lending;
use JWTAuth;
use Zilliqa\Backend\Models\Setting;
use Zilliqa\Backend\Models\UserLending;
use Zilliqa\Backend\Models\Presenter;
use DB;

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
        $users = User::lists('username', 'id');
        return $users;
    }

    public function getLendingIdOptions() {
        $lendings = Lending::lists('title', 'id');
        return $lendings;
    }

    public function afterSave() {
        if ($this->status == 2) {
            //Check Lending Package
            $lending = Lending::find($this->lending_id);
            $package = $lending->title;
            $bonusZil = $lending->bonus_zil;

            //Insert user Lending
            $arrData = [
                'user_id' => $this->user_id, 'lending_id' => $this->lending_id, 'status' => 1, 'is_update_lending' => $lending->is_update_lending
            ];
            UserLending::create($arrData);

            //Update Zill for user
            if ($bonusZil > 0) {
                $user = User::find($this->user_id);
                if ($user) {
                    $zilliqa_minimum = $bonusZil / 10;
                    $user->zilliqa = $user->zilliqa + $bonusZil;
                    $user->lending = $user->lending + $package;
                    $user->zilliqa_minimum = $user->zilliqa_minimum + $zilliqa_minimum;
                    $user->save();
                }
            }

            //Update Business Volume
            DB::table('zilliqa_backend_presenter')->where('user_id', $this->user_id)->increment('business_volume', $package);

            $presenter = new Presenter();
            //Get List Referal
            $list = $presenter->get()->toArray();
            $result = $presenter->showTreePresent($list);
            $presenterList = $presenter->where('user_id', $this->user_id)->first();
            if ($presenterList) {
                $presenterID = $presenterList->parent_id;
                //Update Commission for User
                $this->updateCommissionForPresenter($result, $presenterID, $package);
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAllFilter() {

        //Initialize param for product filter
        //$perPage = $request->get('limit', 100);
        $perPage = 100;

        $user = JWTAuth::parseToken()->authenticate();
        $userID = $user->id;

        $depositModel = $this->whereNull('deleted_at');
        $depositModel->when($userID, function($query, $userID) {
            return $query->where('user_id', $userID);
        });

        $depositModel->orderBy('id', 'desc');

        $result = $depositModel->paginate($perPage)->toArray();

        return $result;
    }

    protected function search($array, $key, $value) {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }

    /**
     * Đệ quy cho các cấp gián tiếp
     * @param Request $request
     * @return mixed
     */
    protected function updateCommissionForPresenter($data, $presenterID, $package) {
        $userCurrent = $this->user_id;
        for ($index = 1; $index < 6; $index++) {
            $referral = $this->search($data, 'user_id', $userCurrent);
            if (count($referral) > 0) {
                if ($userCurrent != $referral[0]['user_present']) {
                    $userCurrent = $referral[0]['user_present'];
                    //Status Lending
                    $statusLending = UserLending::where('user_id', $userCurrent)->where('status', 1)->first();
                    if ($statusLending) {
                        $allowLevel = Presenter::getReferralLevel($userCurrent);
                        if ($allowLevel >= $index) {
                            $percentCommission = Setting::get('percent_f' . $index);
                            $commission = ($percentCommission * $package) / 100;

                            //Save History Commission
                            $arrData = [
                                'user_id' => $userCurrent, 'commission' => $commission
                            ];
                            HistoryCommission::create($arrData);
                        }
                    }
                } else
                    return true;
            } else
                return true;
        }
    }

}
