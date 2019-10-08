<?php namespace Zilliqa\Backend\Models;

use Model;
use Zilliqa\Backend\Models\Lending;

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
    protected $fillable = ['user_id','status', 'lending_id'];

    /**
     * @var array Validation rules
     */
    public $rules = [];

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
