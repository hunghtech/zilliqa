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
    public $belongsTo = [];
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

    public function getDownlineMember($user_id){
        return $this->where('user_id',$user_id)->orWhere('parent_present',$user_id)->get();
    }

    public function showCategories($categories, $parent_id = 0, $char = '', $stt = 0)
    {
        // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
        $cate_child = array();
        foreach ($categories as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['parent_id'] == $parent_id)
            {
                $cate_child[] = $item;
                unset($categories[$key]);
            }
        }

        // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
        if ($cate_child)
        {
            if ($stt == 0){
                // là cấp 1
            }
            else if ($stt == 1){
                // là cấp 2
            }
            else if ($stt == 2){
                // là cấp 3
            }

            echo '<ul>';
            foreach ($cate_child as $key => $item)
            {
                // Hiển thị tiêu đề chuyên mục
                echo '<li>'.$item['title'];
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                showCategories($categories, $item['id'], $char.'|---', ++$stt);
                echo '</li>';
            }
            echo '</ul>';
        }
    }
}
