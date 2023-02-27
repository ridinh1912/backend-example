<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    public function testGetIndex()
    {
        $r = $this->get('/api/addresses')->assertStatus(200);

        dd(json_decode($r->getContent()));
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $address = '123 address';
        $response = $this->post('/api/addresses', [
            'address' => $address,
            'user_id' => $user->id
        ])->assertStatus(201);

        $this->assertDatabaseHas('addresses', [
            'address' => $address,
        ]);

//        dd(json_decode($response->getContent()));
    }
}
