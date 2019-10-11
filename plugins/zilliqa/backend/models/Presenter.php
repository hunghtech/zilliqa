<?php

namespace Zilliqa\Backend\Models;

use Model;
use RainLab\User\Models\User;
use October\Rain\Database\Traits\NestedTree;

/**
 * Model
 */
class Presenter extends Model {

    use \October\Rain\Database\Traits\Validation;
    //use NestedTree;

    protected $userRoot = 0;
    protected $userParent = 0;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'zilliqa_backend_presenter';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['user_id', 'user_present','parent_present'];
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
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    protected $appends = ['user'];

    public function getUserIdOptions() {
        $users = User::lists('name', 'id');
        return $users;
    }
    
    public function getUserPresentOptions() {
        $users = User::lists('name', 'id');
        return $users;
    }
    public function getParentPresentOptions() {
        $users = User::lists('name', 'id');
        return $users;
    }
    
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

    public function getReferralLevel($user_id) {
        return self::where('user_present', $user_id)->count();
    }

    public function getDownlineMember($user_id) {
        return $this->where('user_id', $user_id)->orWhere('parent_present', $user_id)->get();
    }

    function showTreePresent($data, $parent_id = 0, $level = 0) {
        $result = [];
        foreach ($data as $item) {
            if ($item['parent_present'] == $parent_id) {
                $item['level'] = $level;
                if ($level == 1) {
                    $this->userRoot = $item['parent_present'];
                    $this->userParent = $item['parent_present'];
                }
                if ($level == 2) {
                    $this->userRoot = $this->userRoot;
                    $this->userParent = $item['parent_present'];
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

}
