<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('GET','/users',['name' => 'cookie']);

        $response->assertStatus(200)->assertJson([ 'created' => true]);

//        $user = factory(User::class)->create();
//        $response = $this->actingAs($user)
//            ->get('/users')
//            ->assertStatus(200);
    }
}
