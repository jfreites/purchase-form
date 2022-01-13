<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_order_creation_form()
    {
        $response = $this->get('/purchase-order/create');

        $response->assertStatus(200);
        $response->assertSee('Formulario de compra');
    }

    /**
     * Another basic feature test example.
     *
     * @return void
     */
    public function test_order_total_after_request()
    {
        /*
        Preparar el payload que se enviaría por medio del formulario, este payload debe incluir un producto de cada SKU (SKU01, SKU02, SKU03)
        Realizar un post a la ruta que se defina para el store (guardado de orden)
        Realizar los siguientes asserts
            Probar que en db el total de la orden es igual a 385.50
            Probar que uno de los items tenga el product_id que corresponda al SKU02
        */
        $this->markTestSkipped('to be implemented');
    }
}
