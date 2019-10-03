<?php

namespace Zilliqa\Api\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use RainLab\User\Models\User As UserModel;
use Rainlab\User\Models\UserGroup;
use JWTAuth;
use Zilliqa\Api\Repository\UserExtendRepository;
use Zilliqa\Backend\Models\Presenter;
use Zilliqa\Backend\Models\Country;
use Lang;

/**
 * User Back-end Controller
 */
class User extends General {

    protected $userRepository,
            $token, $userGroupRepository,
            $presenterRepository,
            $countryRepository,
            $userExtendRepository;

    public function __construct(UserModel $user, UserGroup $userGroup, Presenter $presenter, UserExtendRepository $userExtend, Country $country) {
        $this->userRepository = $user;
        $this->userGroupRepository = $userGroup;
        $this->presenterRepository = $presenter;
        $this->userExtendRepository = $userExtend;
        $this->countryRepository = $country;
        $this->token = JWTAuth::getToken();
    }

    /**
     * login api
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        try {
            $now = date('Y-m-d H:i:s');
            $username = $request->get('username');
            $password = $request->get('password');
            $credentials = $request->only('username', 'password');
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->respondWithError('Tên đăng nhập hoặc mật khẩu không đúng.', self::HTTP_INTERNAL_SERVER_ERROR);
            }
            $user = $this->userRepository->where('username', $username)->first();
            if ($user) {
                if ($user->is_activated == 0) {
                    return $this->respondWithError('Tài khoản chưa được kích hoạt. Vui lòng liên hệ với admin', self::HTTP_INTERNAL_SERVER_ERROR);
                }
                if (Hash::check($password, $user->password)) {
                    $userModel = JWTAuth::authenticate($token);
                    $user->last_login = $now;
                    $user->save();
                    if ($userModel->methodExists('getAuthApiSigninAttributes')) {
                        $user = $userModel->getAuthApiSigninAttributes();
                    } else {
                        $user->token = JWTAuth::fromUser($user);
                    }
                    return $this->respondWithData($user);
                } else {
                    return $this->respondWithError('Tên đăng nhập hoặc mật khẩu không đúng.', self::HTTP_INTERNAL_SERVER_ERROR);
                }
            } else {
                return $this->respondWithError('Tên đăng nhập hoặc mật khẩu không đúng.', self::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $ex) {
            return $this->respondWithError($ex->getMessage(), self::HTTP_BAD_REQUEST);
        }
    }

    /**
     * logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout() {
        try {
            JWTAuth::invalidate();
            return $this->respondWithMessage('Đăng xuất thành công');
        } catch (\Exception $ex) {
            return $this->respondWithError($ex->getMessage(), self::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Create user
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request) {
        try {
            $userCode = $request->get("user_code");
            //$userCode = base64_decode($userCode);
            $data = $request->post();
            $validator = Validator::make($data, [
                        'name' => 'required|string',
                        'username' => 'required|string',
                        'email' => 'required|string|email|unique:users',
                        'password' => 'required|string|min:6',
                        'user_code' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->respondWithError($validator->errors(), self::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                //Create User
                $credentials = $request->only('name', 'username', 'email', 'password', 'password_confirmation', 'country_id');
                $userModel = UserModel::create($credentials);

                $userModel->save();

                //Add User Commission
                $presenter = $this->userRepository->where('user_code', $userCode)->first()->toArray();
                $presenterID = $presenter['id'];
                $parentPresent = 0;

                $data = $this->presenterRepository->where('user_present', $presenterID)->first();
                if ($data) {
                    $parentPresent = $data->parent_present;
                }
                $arrPresenter = [
                    'user_id' => $userModel->id, 'user_present' => $presenterID, 'parent_present' => $parentPresent
                ];
                $this->presenterRepository->create($arrPresenter);


                $userModel->token = JWTAuth::fromUser($userModel);
                return $this->respondWithData($userModel);
            }
        } catch (Exception $ex) {
            return $this->respondWithError($ex->getMessage(), self::HTTP_BAD_REQUEST);
        }
    }

    /**
     * change Password
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request) {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $password = $user->password;
            $data = $request->post();
            $validator = Validator::make($data, [
                        'current_password' => 'required',
                        'new_password' => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return $this->respondWithError($validator->errors(), self::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                if (!(Hash::check($data['current_password'], $password))) {
                    // The passwords matches
                    return $this->respondWithError('Mật khẩu hiện tại không chính xác.', self::HTTP_METHOD_NOT_ALLOWED);
                }
                if (strcmp($data['current_password'], $data['new_password']) == 0) {
                    //Current password and new password are same
                    return $this->respondWithError('Mật khẩu mới trùng với mật khẩu hiện tại.', self::HTTP_METHOD_NOT_ALLOWED);
                }
                //Change Password
                $newPassword = $request->get('new_password');
                $user->password = $newPassword;
                $user->password_confirmation = $newPassword;
                $user->save();
                return $this->respondWithMessage("Thay đổi mật khẩu thành công.");
            }
        } catch (\Exception $ex) {
            return $this->respondWithError($ex->getMessage(), $ex->getStatusCode());
        }
    }

    /**
     * reset Password
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request) {
        try {
            $data = $request->post();
            $reset_password_token = $data['reset_password_code'];
            $user = $this->userRepository->where('reset_password_code', $reset_password_token)->first();
            if ($user) {
                $newPassword = $request->get('new_password');
                $user->password = $newPassword;
                $user->password_confirmation = $newPassword;
                $user->is_activated = 1;
                $user->reset_password_code = "";
                $user->forceSave();
                return $this->respondWithMessage("Mật khẩu đã cài đặt thành công. <br>Xin vui lòng quay lại trang đăng nhập và sử dụng mật khẩu mới.");
            } else {
                return $this->respondWithError('Liên kết mật khẩu đã hết hạn hoặc đã được sử dụng. <br>Xin vui lòng thử lại.', self::HTTP_NOT_FOUND);
            }
        } catch (\Exception $ex) {
            return $this->respondWithError($ex->getMessage(), self::HTTP_BAD_REQUEST);
        }
    }

    /**
     * send code verify Password
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request) {
        try {
            $data = $request->post();
            $validator = Validator::make($data, [
                        'email' => 'required|string|email',
            ]);
            if ($validator->fails()) {
                return $this->respondWithError($validator->errors(), self::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $user = $this->userRepository->where('email', $request->get('email'))->first();
                if ($user) {
                    $reset_password_token = $this->randomString(30);
                    $user->is_activated = 0;
                    $user->reset_password_code = $reset_password_token;
                    $user->save();
                    $message = $this->sendMailForGot($user, $reset_password_token);
                    return $this->respondWithMessage($message);
                } else {
                    return $this->respondWithError('Tài khoản không tồn tại.<br> Xin vui lòng thử lại.', self::HTTP_NOT_FOUND);
                }
            }
        } catch (\Exception $ex) {
            return $this->respondWithError($ex->getMessage(), self::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update user
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {
        try {
            $data = $request->post();
            $validator = Validator::make($data, [
                        'username' => 'required|string',
                        'email' => 'required|string|email',
                        'zil_address' => 'required',
                        'eth_address' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->respondWithError($validator->errors(), self::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                $userToken = JWTAuth::parseToken()->authenticate();
                $user_id = $userToken->id;
                //Update User
                $user = $this->userRepository->find($user_id);

                /*$password = $request->get('password');
                if (!empty($password)) {
                    $user->fill($request->all(['username', 'email', 'password', 'password_confirmation']));
                } else {
                    $user->fill($request->all(['username', 'email','zil_address','eth_address']));
                }*/
                
                $user->username = $request->get("username");
                $user->email = $request->get("email");
                $user->zil_address = $request->get("zil_address");
                $user->eth_address = $request->get("eth_address");
                $user->save();
                $user->token = JWTAuth::fromUser($user);
                return $this->respondWithData($user);
            }
        } catch (Exception $ex) {
            return $this->respondWithError($ex->getMessage(), self::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listCountry() {
        try {
            $countryList = $this->countryRepository->get();

            return $this->respondWithData($countryList);
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * detail
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function detail() {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if($user)
                return $this->respondWithData($user->toArray());
            else
                return $this->respondWithData();
        } catch (\Exception $ex) {
            return $this->respondWithError($ex->getMessage(), $ex->getStatusCode());
        }
    }

    /**
     * checkReferal
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function checkReferal(Request $request) {
        try {
            $userCode = $request->get('user_code');
            $user = $this->userRepository->where('user_code', $userCode)->get();
            return $this->respondWithData($user);
        } catch (\Exception $ex) {
            return $this->respondWithError($ex->getMessage(), $ex->getStatusCode());
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListReferal() {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if($user){
                $userID = $user->id;
                $list = $this->presenterRepository->where('user_present',$userID)->get();
                return $this->respondWithData($list);
            }
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

}
