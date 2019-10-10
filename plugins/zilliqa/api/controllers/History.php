<?php

namespace Zilliqa\API\Controllers;

use Illuminate\Http\Request;
use Zilliqa\Backend\Models\HistoryDeposit;
use Zilliqa\Backend\Models\HistoryWithDraw;
use Zilliqa\Backend\Models\HistoryDaily;
use Zilliqa\Backend\Models\HistoryCommission;
use RainLab\User\Models\User;
use Validator;
use JWTAuth;

/**
 * History Back-end Controller
 */
class History extends General {

    protected $depositRepository, $withDrawRepository, $dailyRepository, $commissionRepository, $userRepository;

    public function __construct(HistoryDeposit $deposit, HistoryWithDraw $withdraw, HistoryDaily $daily, HistoryCommission $commission, User $user) {
        $this->depositRepository = $deposit;
        $this->withDrawRepository = $withdraw;
        $this->dailyRepository = $daily;
        $this->commissionRepository = $commission;
        $this->userRepository = $user;
    }

    /**
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function historyDeposit(Request $request) {
        try {
            $depositListPagination = $this->depositRepository->getAllFilter($request);
            $depositListData = $depositListPagination['data'];

            //Paging object
            $paginateArr = [];
            $paginateArr['total_item'] = $depositListPagination['total'];
            $paginateArr['per_page'] = $depositListPagination['per_page'];
            $paginateArr['current_page'] = $depositListPagination['current_page'];
            $paginateArr['total_pages'] = $depositListPagination['last_page'];

            return $this->respondWithDataPaging($depositListData, $paginateArr);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function historyWithDraw(Request $request) {
        try {
            $withDrawListPagination = $this->withDrawRepository->getAllFilter($request);
            $withDrawListData = $withDrawListPagination['data'];

            //Paging object
            $paginateArr = [];
            $paginateArr['total_item'] = $withDrawListPagination['total'];
            $paginateArr['per_page'] = $withDrawListPagination['per_page'];
            $paginateArr['current_page'] = $withDrawListPagination['current_page'];
            $paginateArr['total_pages'] = $withDrawListPagination['last_page'];

            return $this->respondWithDataPaging($withDrawListData, $paginateArr);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }
    
     /**
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function historyDaily(Request $request) {
        try {
            $dailyListPagination = $this->dailyRepository->getAllFilter($request);
            $dailyListData = $dailyListPagination['data'];

            //Paging object
            $paginateArr = [];
            $paginateArr['total_item'] = $dailyListPagination['total'];
            $paginateArr['per_page'] = $dailyListPagination['per_page'];
            $paginateArr['current_page'] = $dailyListPagination['current_page'];
            $paginateArr['total_pages'] = $dailyListPagination['last_page'];

            return $this->respondWithDataPaging($dailyListData, $paginateArr);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }
    
    /**
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function historyCommission(Request $request) {
        try {
            $commissionListPagination = $this->commissionRepository->getAllFilter($request);
            $commissionListData = $commissionListPagination['data'];

            //Paging object
            $paginateArr = [];
            $paginateArr['total_item'] = $commissionListPagination['total'];
            $paginateArr['per_page'] = $commissionListPagination['per_page'];
            $paginateArr['current_page'] = $commissionListPagination['current_page'];
            $paginateArr['total_pages'] = $commissionListPagination['last_page'];

            return $this->respondWithDataPaging($commissionListData, $paginateArr);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeDeposit(Request $request) {
        try {
            $this->valiadatedRequest($request);
            $deposit = $this->depositRepository->create($request->all(['user_id', 'coint', 'amount', 'status', 'lending_id']));
            if ($deposit) {
                $user = JWTAuth::parseToken()->authenticate();
                $this->sendMailConfirmDeposit($user, $deposit);
            }
            return $this->respondWithData($deposit);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeWithDraw(Request $request) {
        try {
            $this->valiadatedRequest($request);
            $withDraw = $this->withDrawRepository->create($request->all(['user_id', 'coint', 'amount', 'status', 'type']));
            if ($withDraw) {
                $user = JWTAuth::parseToken()->authenticate();
                $this->sendMailConfirmWithDraw($user, $withDraw);
            }
            return $this->respondWithData($withDraw);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    protected function valiadatedRequest($request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'coint' => 'required',
                    'amount' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->respondWithError($validator->errors(), 500);
        }
    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function updateDeposit(Request $request) {
        try {            
            $historyId = $request->get('history_id');
            $deposit = $this->depositRepository->find($historyId);
            if($deposit){
                $deposit->status = 1;
                $deposit->save();
                $userID = $deposit->user_id;
                $user = $this->userRepository->find($userID);
                $this->sendMailAdminActiveDeposit($user, $deposit);
                return $this->respondWithData($deposit);
            }
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function updateWithDraw(Request $request) {
        try {            
            $historyId = $request->get('history_id');
            $withDraw = $this->withDrawRepository->find($historyId);
            if($withDraw){
                $withDraw->status = 1;
                $withDraw->save();
                $userID = $withDraw->user_id;
                $user = $this->userRepository->find($userID);
                $this->sendMailAdminActiveWithDraw($user, $withDraw);
                return $this->respondWithData($withDraw);
            }
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

}
