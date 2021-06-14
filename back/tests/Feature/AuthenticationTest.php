<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Index route of api expected test
     * @return void
     */
    public function testIndexRouteExpectedMessage()
    {
        $response = $this->get('api/');
        $data = json_decode($response->getContent());
        $this->assertEquals(200, $response->status());
        $this->assertEquals("PHP Challenge 20201117",  $data->message, 'È  igual');
    }
    /**
     * Test get token with  valid login
     *
     * @return void
     */
    public function testGetTokenWithValidLogin()
    {
       User::factory()->create(['email' => 'carlos@gmail.com', 'password' => bcrypt('1223')]);
        $this->post('/api/signIn', [
            'email' => 'carlos@gmail.com',
            'password' => '1223'
        ])->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }
    /**
     * Test get token with not valid login
     *
     * @return void
     */
    public function testGetTokenWithNotValidLogin()
    {
        User::factory()->create(['email' => 'carlos@gmail.com']);
        $this->post('/api/signIn', [
            'email' => 'carlos@gmail.com',
            'password' => '1222'
        ])->assertUnauthorized();
    }
    public function testTryingToAccessRoutesWithoutToken()
    {
        $this->get('api/products?page=1')->assertRedirect();
        $this->post('api/products/')->assertRedirect();
        $this->put('api/products/1')->assertRedirect();
        $this->delete('api/products/1')->assertRedirect();
    }
}
