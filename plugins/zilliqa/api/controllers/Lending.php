<?php

namespace Zilliqa\API\Controllers;

use Zilliqa\Backend\Models\Lending AS LendingModel;
use Illuminate\Http\Request;
use Zilliqa\Backend\Models\UserLending;
use JWTAuth;

/**
 * Lending Back-end Controller
 */
class Lending extends General {

    protected $lendingRepository, $userLendingRepository;

    public function __construct(LendingModel $lendingModel, UserLending $userLendingModel) {
        $this->lendingRepository = $lendingModel;
        $this->userLendingRepository = $userLendingModel;
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
                $lendingList = $this->userLendingRepository->where('status', 1)->where('user_id',$userId)->get();
                return $this->respondWithData($lendingList);
            }
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }

}
