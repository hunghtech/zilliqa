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
                'user_id' => $this->user_id, 'lending_id' => $this->lending_id, 'status' => 1,'is_update_lending' => $lending->is_update_lending
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
            $presenter = new Presenter();
            //Get List Referal
            $list = $presenter->get()->toArray();
            $result = $presenter->showTreePresent($list);
            $presenterList = $presenter->where('user_id', $this->user_id)->first();
            $presenterID = $presenterList->parent_present;
            //Update Commission for User
            $this->updateCommissionForPresenter($result, $presenterID, $package);
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

        return $depositModel->get()->toArray();
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
     * Cập nhật Commission cho cấp 1
     * @param Request $request
     * @return mixed
     */
    protected function updateCommissionDirectLevel($data, $presenterID, $package)
    {
        $referralList = $this->search($data, 'user_parent', $presenterID);
        $referral = $this->search($referralList, 'user_id', $this->user_id);
        if(count($referral) > 0){
            $percentCommission = Setting::get('percent_f1');
            $user_present = $referral[0]['user_present'];

            //Status Lending
            $statusLending = UserLending::where('user_id',$user_present)->where('status',1)->first();
            if($statusLending){
                $commission = ($percentCommission * $package) / 100;
                //Update Business Volume
                DB::table('zilliqa_backend_presenter')->where('user_id', $this->user_id)->update(['business_volume' => $package]);

                //Save History Commission
                $arrData = [
                    'user_id' => $user_present, 'commission' => $commission
                ];
                HistoryCommission::create($arrData);
            }
        }
    }

    /**
     * Đệ quy cho các cấp gián tiếp
     * @param Request $request
     * @return mixed
     */
    protected function updateCommissionForPresenter($data, $presenterID, $package){
        $userCurrent = $this->user_id;
        for($index = 1; $index < 6; $index++)
        {
            $referral = $this->search($data, 'user_id', $userCurrent);
            if(count($referral) > 0){
                if($userCurrent != $referral[0]['user_present']){
                    $userCurrent = $referral[0]['user_present'];
                    //Status Lending
                    $statusLending = UserLending::where('user_id',$userCurrent)->where('status',1)->first();
                    if($statusLending){
                        $allowLevel = Presenter::getReferralLevel($userCurrent);
                        if($allowLevel >= $index){
                            $percentCommission = Setting::get('percent_f'.$index);
                            $commission = ($percentCommission * $package) / 100;
                            //Update Business Volume
                            DB::table('zilliqa_backend_presenter')->where('user_id', $userCurrent)->update(['business_volume' => $package]);

                            //Save History Commission
                            $arrData = [
                                'user_id' => $userCurrent, 'commission' => $commission
                            ];
                            HistoryCommission::create($arrData);
                        }
                    }
                }
                else
                    return true;
            }
            else
                return true;
        }
    }
}
