<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefundRequest;
use App\Services\Contracts\IRefundService;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    private $refundService;

    public function __construct(IRefundService $refundService)
    {
        $this->refundService = $refundService;
    }

    public function store(StoreRefundRequest $request)
    {

        $refund = $this->refundService->createRefund($request->all());

        return redirect()->route('vouchers.index')->with('refund', $refund->toArray());
    }
}
