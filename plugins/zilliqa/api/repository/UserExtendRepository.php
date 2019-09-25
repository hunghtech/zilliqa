<?php

namespace Zilliqa\Api\Repository;

use October\Rain\Auth\Models\User as UserBase;

class UserExtendRepository extends UserBase {

    use \October\Rain\Database\Traits\SoftDelete;

    public function customRule($email, $code) {
        $message = [];
        $checkEmailDelete = $this->checkUserDeleted(['email' => $email]);
        if (!empty($checkEmailDelete)) {
            array_push($message, ['email' => ['Địa chỉ email đã tồn tại trên hệ thống. Nhưng đã bị khóa. Vui lòng liên hệ quản trị.']]);
        }
        $checkCodeDelete = $this->checkUserDeleted(['code' => $code]);
        if (!empty($checkCodeDelete)) {
            array_push($message, ['code' => ['Mã nhân viên đã tồn tại trên hệ thống. Nhưng đã bị khóa. Vui lòng liên hệ quản trị.']]);
        }
        return $message;
    }

    protected function checkUserDeleted($arrayFilter = ['email' => null]) {
        return $this->withTrashed()->where($arrayFilter)
                        ->whereNotNull('deleted_at')->get()
                        ->toArray();
    }

    public function getListGroup($user_id) {
        $user = $this->find($user_id);
        $userGroup = $user->getGroups();
        if (isset($userGroup)) {
            $userGroup = $userGroup[0]->toArray();
            unset($userGroup['pivot']);
            return $userGroup;
        }
        return false;
    }
}