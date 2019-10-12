<?php

namespace Zilliqa\Api\Controllers;

use \Illuminate\Routing\Controller;
use Mail;
use PHPExcel_IOFactory;
use Zilliqa\Backend\Models\Setting;
use RainLab\User\Models\User AS UserModel;
use RainLab\User\Models\UserGroup;
use Illuminate\Http\Response;

/**
 * General Back-end Controller
 */
class General extends Controller {

    protected $statusCode = Response::HTTP_OK;

    const HTTP_NOT_FOUND = Response::HTTP_NOT_FOUND;
    const HTTP_INTERNAL_SERVER_ERROR = Response::HTTP_INTERNAL_SERVER_ERROR;
    const HTTP_BAD_REQUEST = Response::HTTP_BAD_REQUEST;
    const HTTP_UNAUTHORIZED = Response::HTTP_UNAUTHORIZED;
    const HTTP_METHOD_NOT_ALLOWED = Response::HTTP_METHOD_NOT_ALLOWED;

    public function __construct() {

    }

    protected function getStatusCode() {
        return $this->statusCode;
    }

    protected function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    protected function respondWithError($message = null, $statusCode = null) {
        if (is_null($statusCode)) {
            $this->setStatusCode(200);
        } else {
            $this->setStatusCode($statusCode);
        }
        $response = [
            'error' => true,
            'error_code' => $this->getStatusCode(),
            'message' => $message,
        ];

        return $this->respondWithArray($response);
    }

    protected function respondWithArray(array $array, array $headers = []) {
        return response()->json($array, $this->statusCode, $headers);
    }

    protected function respondWithSuccess($data = []) {
        $response = [
            'error' => false,
            'error_code' => $this->getStatusCode(),
            'data' => $data,
        ];

        return $this->respondWithArray($response);
    }

    protected function respondWithData($data = [], array $headers = []) {
        $array = array_merge([
            'error' => false,
            'error_code' => $this->getStatusCode(),
            'data' => $data,
        ]);
        return $this->respondWithArray($array, $headers);
    }

    protected function respondWithDataPaging($data = [], $pagination = []) {
        $array = array_merge([
            'error' => false,
            'error_code' => $this->getStatusCode(),
            'data' => $data,
            'paging' => $pagination
        ]);
        return $this->respondWithArray($array);
    }

    protected function respondWithMessage($message, array $headers = []) {
        $array = array_merge([
            'error' => false,
            'error_code' => $this->getStatusCode(),
            'message' => $message,
        ]);
        return $this->respondWithArray($array, $headers);
    }

    protected function checkAuthUser($request) {
        $user = $request->user();
        if (!$user) {
            return $this->respondWithError('user is invalid', 404);
        }
    }

    /**
     * random String Password
     *
     * @return \Illuminate\Http\Response
     */
    public static function randomString($length = 10) {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    public function getRandomCode($length = 6) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * validate request update profile
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMailForGot($user, $reset_password_token) {
        //$url_app = Setting::get('link_app');
        $url_app = 'http://zilliqa-network.com';
        $url = $url_app . '/reset-password?token=' . $reset_password_token;
        Mail::send('zilliqa.api::mail.resetpassword', ['user' => $user, 'url' => $url], function ($m) use ($user) {
            $m->from('do-not-reply@zilliqa-network.com', 'Zilliqa Network');

            $m->to($user->email, $user->name)->subject('[ZILLIQA-NETWORK] Reset your password');
        });
        if (Mail::failures()) {
            return 'Mail not sent';
        } else {
            return 'Hệ thống đã gửi một liên kết để cài đặt lại mật khẩu. <br>Xin vui lòng kiểm tra hộp thư của bạn.';
        }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMailConfirmDeposit($user, $data) {
        $url_app = 'http://zilliqa-network.com';
        $userID = $user->id;
        $randomToken = $this->randomString();
        $recordId = $data->id;
        $amount = $data->amount;
        $logo = url('/') . "/plugins/zilliqa/api/assets/images/logo.png";
        $svg = url('/') . "/plugins/zilliqa/api/assets/images/Zilliqa-bg.svg";
        $token = base64_encode($userID . "-" . $recordId . "-" . $randomToken);
        $url = $url_app . '/confirm-deposit?token=' . $token;
        Mail::send('zilliqa.api::mail.deposit', ['user' => $user, 'url' => $url, 'amount' => $amount, 'logo' => $logo, 'svg' => $svg], function ($m) use ($user) {
            $m->from('do-not-reply@zilliqa-network.com', 'Zilliqa Network');

            $m->to($user->email, $user->name)->subject('[ZILLIQA-NETWORK] Deposit Confirmation');
        });
        if (Mail::failures()) {
            return 'Mail not sent';
        } else {
            return 'Hệ thống đã gửi một liên kết để cài đặt lại mật khẩu. <br>Xin vui lòng kiểm tra hộp thư của bạn.';
        }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMailConfirmWithDraw($user, $data) {
        $url_app = 'http://zilliqa-network.com';
        $userID = $user->id;
        $randomToken = $this->randomString();
        $recordId = $data->id;
        $amount = $data->amount;
        $wallet_address = $data->wallet_address;
        $logo = url('/') . "/plugins/zilliqa/api/assets/images/logo.png";
        $svg = url('/') . "/plugins/zilliqa/api/assets/images/Zilliqa-bg.svg";
        $token = base64_encode($userID . "-" . $recordId . "-" . $randomToken);
        $url = $url_app . '/confirm-withdraw?token=' . $token;
        Mail::send('zilliqa.api::mail.withdraw', ['user' => $user, 'url' => $url, 'amount' => $amount, 'logo' => $logo, 'wallet_address' => $wallet_address], function ($m) use ($user) {
            $m->from('do-not-reply@zilliqa-network.com', 'Zilliqa Network');

            $m->to($user->email, $user->name)->subject('[ZILLIQA-NETWORK] Withdrawal Requested');
        });
        if (Mail::failures()) {
            return 'Mail not sent';
        } else {
            return 'Hệ thống đã gửi một liên kết để cài đặt lại mật khẩu. <br>Xin vui lòng kiểm tra hộp thư của bạn.';
        }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMailAdminActiveDeposit($user, $data) {
        $logo = url('/') . "/plugins/zilliqa/api/assets/images/logo.png";
        $svg = url('/') . "/plugins/zilliqa/api/assets/images/Zilliqa-bg.svg";
        Mail::send('zilliqa.api::mail.activedeposit', ['user' => $user,'logo' => $logo, 'svg' => $svg, 'data' =>$data], function ($m) use ($user) {
            $m->from('do-not-reply@zilliqa-network.com', 'Zilliqa Network');
            $m->to('hungdn0502@gmail.com', "Đỗ Như Hưng");
            $m->to('le.quang.thuan286@gmail.com', "Lê Quang Thuận");
            $m->subject('[Zilliqa NetWork] Xác nhận nạp tiền');
        });
        if (Mail::failures()) {
            return 'Mail not sent';
        } else {
            return 'Hệ thống đã gửi một liên kết để cài đặt lại mật khẩu. <br>Xin vui lòng kiểm tra hộp thư của bạn.';
        }
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMailAdminActiveWithDraw($user, $data) {
        $logo = url('/') . "/plugins/zilliqa/api/assets/images/logo.png";
        $svg = url('/') . "/plugins/zilliqa/api/assets/images/Zilliqa-bg.svg";
        Mail::send('zilliqa.api::mail.activewithdraw', ['user' => $user,'logo' => $logo, 'svg' => $svg, 'data' => $data], function ($m) use ($user) {
            $m->from('do-not-reply@zilliqa-network.com', 'Zilliqa Network');
            $m->to('hungdn0502@gmail.com', "Đỗ Như Hưng");
            $m->to('le.quang.thuan286@gmail.com', "Lê Quang Thuận");
            $m->subject('[Zilliqa NetWork] Xác nhận rút tiền');
        });
        if (Mail::failures()) {
            return 'Mail not sent';
        } else {
            return 'Hệ thống đã gửi một liên kết để cài đặt lại mật khẩu. <br>Xin vui lòng kiểm tra hộp thư của bạn.';
        }
    }

}
