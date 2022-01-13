<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Services\PurchaseOrderService;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * show the purchase form to user
     *
     * @return void
     */
    public function create()
    {
        return view('purchase-order.create', [
            'products' => Product::all(),
        ]);
    }

    /**
     * Validate the payload and persist the order.  An ajax request is expected (TODO VALIDATE THAT)
     *
     * @param Request $request
     * @return void
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        // Save order items
        if (! PurchaseOrderService::saveOrderItems($request->all())) {
            session()->flash('warning', __('Something went wrong. Please contact to support!'));

            return response()->json([
                'message' => __('Something went wrong. Please contact to support!')
            ], 400);
        }

        session()->flash('success', __('The order was placed correctly!'));

        return response()->json([
            'message' => __('The order was placed correctly!')
        ]);
    }
}
