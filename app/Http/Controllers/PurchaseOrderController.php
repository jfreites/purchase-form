<?php

namespace App\Http\Controllers;

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
     * Validate the payload and persist the order
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        /*
        $data = [
            "_token" => "dTTUUWqxc28l9x7IURmbEZ4JMU0bP7wcLaRh5aYg"
            "cart_product" => array:2 [▼
                0 => "SKU02"
                1 => "SKU03"
            ]
            "sku_SKU02" => "1"
            "sku_SKU03" => "3"
        ];
        */

        $validData = $request->validate([
            'product_sku' => 'required',
            'quantity'    => 'required|integer|min:1',
        ]);

        // Save order items
        if (! PurchaseOrderService::saveOrderItems($validData)) {
            return back()->with('error', __('Something went wrong. Please contact to support!'));
        }

        return redirect()->to('/')->with('success', __('Successfully placed order!'));
    }
}
