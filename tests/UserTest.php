<?php

namespace Brotzka\Affiliate\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\user;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUser()
    {
        $user = new User(['name' => 'Fabian', 'email' => 'fabianhagen87@gmail.com']);
        $this->assertEquals('Fabian', $user->name);

        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
