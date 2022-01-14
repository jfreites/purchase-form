<?php

namespace App\Http\Services;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderService
{
    /**
     * Get all products with or without associations
     *
     * @param array|null $with
     * @return Collection
     */
    public static function getProducts($with = null): Collection
    {
        return is_null($with) ? Product::all() : Product::with($with)->get();
    }

    /**
     * Save order items from the request.
     *
     * @return bool
     */
    public static function savePurchaseOrder(array $items): bool
    {
        // Because we are gonna to perform a lot of inserts better prepare a db transaction
        DB::beginTransaction();

        try {
            // Create an order with 0 as total just for have the ID
            $order = new Order;
            $order->total = 0;
    
            $order->save();

            list($orderItems, $orderTotal) = static::prepareOrderItems($order->id, $items);

            // Update the total for the order
            $order->total = $orderTotal;
            $order->save();
    
            // Bulk insert
            Item::insert($orderItems);

            // It's safetly to commit the operations
            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    /**
     * Helper function to create an prepared array with order items and sum their totals
     *
     * @param int $orderId
     * @param array $orderItems
     */
    private static function prepareOrderItems(int $orderId, array $items): array 
    {
        $orderTotal = 0;
        $orderItems = [];

        foreach($items as $item) {
            $product = Product::where('sku', $item['sku'])->first();
            
            $total      = $product->price * $item['qty'];
            $orderTotal += $total;

            $orderItem = [
                'order_id'   => $orderId,
                'product_id' => $product->id,
                'quantity'   => $item['qty'],
                'total'      => $total,
                'created_at' => Carbon::now()
            ];

            array_push($orderItems, $orderItem);
        }

        return [$orderItems, $orderTotal];
    }
}