<?php

namespace Zilliqa\API\Controllers;

use Zilliqa\Backend\Models\Lending AS LendingModel;
use Illuminate\Http\Request;

/**
 * Lending Back-end Controller
 */
class Lending extends General {

    protected $lendingRepository;

    public function __construct(LendingModel $lendingModel) {
        $this->lendingRepository = $lendingModel;
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAll() {
        try {
            $lendingList = $this->lendingRepository->get();
                        
            return $this->respondWithData($lendingList);
        } catch (Exception $ex) {
            return $this->respondWithError($ex->getMessage(), v);
        }
    }

}
