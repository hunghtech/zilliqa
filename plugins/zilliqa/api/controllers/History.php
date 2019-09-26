<?php namespace Zilliqa\API\Controllers;

use Illuminate\Http\Request;
use Zilliqa\Backend\Models\HistoryDeposit;
use Zilliqa\Backend\Models\HistoryWithDraw;

/**
 * History Back-end Controller
 */
class History extends General
{
    protected $depositRepository,$withDrawRepository;
    public function __construct(HistoryDeposit $deposit, HistoryWithDraw $withdraw)
    {        
        $this->depositRepository = $deposit;
        $this->withDrawRepository = $withdraw;
    }
    
    /**
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function historyDeposit(Request $request) {
        try {
            $depositListPagination = $this->depositRepository->getAllFilter($request);
            $depositListData       = $depositListPagination['data'];

            //Paging object
            $paginateArr                 = [];
            $paginateArr['total_item']   = $depositListPagination['total'];
            $paginateArr['per_page']     = $depositListPagination['per_page'];
            $paginateArr['current_page'] = $depositListPagination['current_page'];
            $paginateArr['total_pages']  = $depositListPagination['last_page'];

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
            $withDrawListData       = $withDrawListPagination['data'];

            //Paging object
            $paginateArr                 = [];
            $paginateArr['total_item']   = $withDrawListPagination['total'];
            $paginateArr['per_page']     = $withDrawListPagination['per_page'];
            $paginateArr['current_page'] = $withDrawListPagination['current_page'];
            $paginateArr['total_pages']  = $withDrawListPagination['last_page'];

            return $this->respondWithDataPaging($withDrawListData, $paginateArr);
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage(), \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
    }
}
