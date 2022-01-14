<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Services\PurchaseOrderService;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * PurchaseOrderServive
     */
    protected $purchaseOrderService;

    /**
     * Construct function
     *
     * @param PurchaseOrderService $purchaseOrderService
     */
    public function __construct(PurchaseOrderService $purchaseOrderService)
    {
        $this->purchaseOrderService = $purchaseOrderService;
    }

    /**
     * show the purchase form to user.
     *
     * @return void
     */
    public function create()
    {
        return view('purchase-order.create', [
            'products' => $this->purchaseOrderService->getProducts(),
        ]);
    }

    /**
     * Create a purchase order by an ajax request.
     *
     * @param Request $request
     * @return void
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        // Save order items
        if (! $this->purchaseOrderService->savePurchaseOrder($request->all())) {
            session()->flash('warning', __('Something went wrong. Please contact to support!'));

            return response()->json([
                'message' => __('Something went wrong. Please contact to support!')
            ]);
        }

        session()->flash('success', __('The order was placed correctly!'));

        return response()->json([
            'message' => __('The order was placed correctly!')
        ]);
    }
}
