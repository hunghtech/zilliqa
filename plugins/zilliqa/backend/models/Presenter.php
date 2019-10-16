<?php

namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use DB;

/**
 * Model
 */
class Presenter extends Model {

    use \October\Rain\Database\Traits\SimpleTree;
    use \October\Rain\Database\Traits\Validation;

    protected $userRoot = 0;
    protected $userParent = 0;
    protected $totalMember = 0;
    protected $totalLending = 0;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_presenter';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'user_present', 'parent_id'];
    protected $hidden = ['updated_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'children' => ['Zilliqa\Backend\Models\Presenter', 'key' => 'parent_id']
    ];
    public $belongsTo = [
        'parent' => ['Zilliqa\Backend\Models\Presenter', 'key' => 'parent_id'],
        'user' => ['RainLab\User\Models\User', 'key' => 'user_id'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    protected $appends = ['userInfo'];

    public function getUserIdOptions() {
        $users = User::lists('name', 'id');
        return $users;
    }

    public function getUserPresentOptions() {
        $users = User::lists('name', 'id');
        return $users;
    }

    public function getParentIdOptions() {
        $array_parent = array('0' => '------  Please Select Parent  --------');
        $parent = self::leftJoin('users', 'users.id', '=', 'zilliqa_backend_presenter.user_id')
                        ->select(DB::raw("CONCAT(zilliqa_backend_presenter.id,'-',users.username) AS full"), 'zilliqa_backend_presenter.id'
                        )->lists('full', 'id');
        $result = $array_parent + $parent;
        return $result;
    }

    /**
     * @return mixed
     */
    public function getUserInfoAttribute() {
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

    public static function getReferralLevel($user_id) {
        return self::where('user_present', $user_id)->count();
    }

    public function getDownlineMember($user_id) {
        return $this->where('user_id', $user_id)->orWhere('parent_id', $user_id)->get();
    }

    function showTreePresent($data, $parent_id = 0, $level = 0) {
        $result = [];
        foreach ($data as $item) {
            if ($item['parent_id'] == $parent_id) {
                $item['level'] = $level;
                if ($level == 1) {
                    $this->userRoot = $item['parent_id'];
                    $this->userParent = $item['parent_id'];
                }
                if ($level == 2) {
                    $this->userRoot = $this->userRoot;
                    $this->userParent = $item['parent_id'];
                } else {
                    if ($this->userRoot > 0)
                        $this->userRoot = $this->userRoot;
                }
                $item['user_root'] = $this->userRoot;
                $item['user_parent'] = $this->userParent;
                $result[] = $item;
                //unset($data[$item['id']]);
                $child = $this->showTreePresent($data, $item['id'], $level + 1);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }

    public function getListReferal($userID) {
        $data = $this->all()->toNested()->toArray();
        $returnData = $this->search($data, 'user_present', $userID, "equal");
        
        foreach ($returnData as $index => $item) {
            $childrens = $item['children'];
            if ($childrens) {
                $this->getTreeChildren($childrens);
            }
            $returnData[$index]['totalMember'] = $this->totalMember;
            $returnData[$index]['totalLending'] = $this->totalLending + $item['business_volume'];
            $this->totalMember = 0;
            $this->totalLending = 0;
            unset($returnData[$index]['children']);
        }
        return $returnData;
    }

    protected function getTreeChildren($childrens) {
        if ($childrens) {
            foreach ($childrens as $children) {
                $this->totalMember++;
                $this->totalLending += $children['business_volume'];               
                $list = $children['children'];
                $this->getTreeChildren($list);                
            }
        }
        return true;
    }
    
    protected function search($array, $key, $value, $condition) {
        $results = array();
        if (is_array($array)) {
            if ($condition == "equal") {
                if (isset($array[$key]) && $array[$key] == $value) {
                    $results[] = $array;
                }
            } else {
                if (isset($array[$key]) && $array[$key] != $value) {
                    $results[] = $array;
                }
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value, $condition));
            }
        }

        return $results;
    }

}
