<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProductMasterQuantityTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_if_quantity_updates_correctly()
    {
       $product = factory(Product::class)->create();

       $inventory = factory(Inventory::class)->create([
           "product_id" => $product->id
       ]);

       $quantity_expected = $product->quantity + $inventory->quantity;

       $product = $product->fresh();

       $this->assertEquals($quantity_expected, $product->quantity);
    }
}
