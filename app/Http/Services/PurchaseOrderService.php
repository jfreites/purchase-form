<?php

namespace App\Http\Services;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderService
{
    /**
     * Save order items from the request
     *
     * @return bool
     */
    public static function saveOrderItems(array $items): bool
    {
        $orderTotal = 0;
        $orderItems = [];

        // Because we are gonna to perform a lot of inserts better prepare a db transaction
        DB::beginTransaction();

        try {
            $order = new Order;
            $order->total = $orderTotal;
    
            $order->save();

            $order->fresh();

            foreach($items as $item) {
                $product = Product::where('sku', $item['sku'])->first();
                $total = $product->price * $item['qty'];
    
                $orderItem = [
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'total'      => $total,
                    'created_at' => Carbon::now()
                ];
    
                $orderTotal += $product->price;
    
                array_push($orderItems, $orderItem);
            }

            // Update the total for the order
            $order->total = $orderTotal;
            $order->save();
    
            // Bulk insert
            Item::insert($orderItems);

            // It's safetly to commit the operations
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return false;
        }

        return true;
    }
}