<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the purchase order creation page is available.
     *
     * @return void
     */
    public function test_order_creation_form()
    {
        $response = $this->get('/purchase-order/create');

        $response->assertStatus(200);
        $response->assertSee('Creación de orden de compra');
    }

    /**
     * Test that a request is perfomed correctly and the items exists in the DB.
     *
     * @return void
     */
    public function test_order_total_after_request()
    {
        $p1 = Product::factory()->create([
            'sku' => 'SKU01',
            'price' => '125.50'
        ]);

        $p2 = Product::factory()->create([
            'sku' => 'SKU02',
            'price' => '210'
        ]);

        $p3 = Product::factory()->create([
            'sku' => 'SKU03',
            'price' => '50'
        ]);

        $payload = [
            ['sku' => $p1->sku, 'qty' => 1],
            ['sku' => $p2->sku, 'qty' => 1],
            ['sku' => $p3->sku, 'qty' => 1]
        ];

        $response = $this->postJson('/purchase-order/create', $payload);

        $response->assertStatus(200)->assertJson([
            'message' => 'The order was placed correctly!'
        ]);

        $this->assertDatabaseCount('order_items', 3);
        
        $this->assertDatabaseHas('orders', [
            'total' => 385.50,
        ]);
        
        $this->assertDatabaseHas('order_items', [
            'product_id' => $p2->id,
        ]);
    }
}
