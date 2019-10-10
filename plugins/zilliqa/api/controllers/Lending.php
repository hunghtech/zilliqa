<?php

namespace Zilliqa\API\Controllers;

use Zilliqa\Backend\Models\Lending AS LendingModel;
use Illuminate\Http\Request;
use Zilliqa\Backend\Models\UserLending;
use Zilliqa\Backend\Models\HistoryDeposit;
use JWTAuth;
use Zilliqa\Backend\Models\Setting;

/**
 * Lending Back-end Controller
 */
class Lending extends General {

    protected $lendingRepository, $userLendingRepository, $depositRepository;

    public function __construct(LendingModel $lendingModel, UserLending $userLendingModel, HistoryDeposit $deposit) {
        $this->lendingRepository = $lendingModel;
        $this->userLendingRepository = $userLendingModel;
        $this->depositRepository = $deposit;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAll() {
        try {
            $lendingList = $this->lendingRepository->get();

            return $this->respondWithData($lendingList);
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscription() {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user) {
                $userId = $user->id;
                $lendingList = $this->userLendingRepository->where('status', 1)->where('user_id', $userId)->get();
                return $this->respondWithData($lendingList);
            }
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPriceETH() {
        try {
            $data = Setting::get('eth');

            return $this->respondWithData($data);
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkLendingStatus() {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user) {
                $userId = $user->id;
                $lendingList = $this->userLendingRepository->where('status', 1)->where('user_id', $userId)->first();
                return $this->respondWithData($lendingList);
            }
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

}
