<?php

namespace Tests\Feature\Http\Controllers\Csv;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Csv\PartialOrderShipmentController
 */
class PartialOrderShipmentControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('partial_order_shipments_as_csv'));

        $response->assertOk();

        // TODO: perform additional assertions
    }

    // test cases...
}