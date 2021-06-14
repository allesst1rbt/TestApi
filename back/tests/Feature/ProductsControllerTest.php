<?php

namespace Tests\Feature;

use App\Jobs\CreateProductAsync;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test get with authorization
     *
     * @return void
     */
    public function testGetProductsWithToken()
    {

        $user =User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $response = $this->actingAs($user,'api')->get('api/products?page=1');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->status());
        $this->assertEquals("dados recuperados com sucesso",  $data->message, 'È  igual');

    }
    /**
     * Test Create product with authorization
     *
     * @return void
     */
    public function testCreateProductWithExpectedData()
    {
        Queue::fake();
        $user =User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $Product = [[
            "title"=> "Anything",
            "type"=> "Anything",
            "description"=> "Anything",
            "filename"=> "Anything",
            "height"=> "400",
            "width"=> "500",
            "price"=> "30.0",
            "rating"=> "4"
        ]];
        $response = $this->actingAs($user,'api')->post('api/products/',$Product);
        $data = json_decode($response->getContent());
        Queue::assertPushedOn('createProducts', CreateProductAsync::class);
        $this->assertEquals(200, $response->status());
        $this->assertEquals("produtos cadastrados com sucesso",  $data->message, 'È  igual');

    }
    public function testCreateProductWithUnexpectedData()
    {
        $user = User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $Product = [[
            "title"=> "Anything",
            "type"=> "Anything",
            "description"=> "Anything",
        ]];
       $this->actingAs($user,'api')->post('api/products/',$Product)->assertStatus(302);

    }
    public  function testUpdateProductWithExpectedData(){
        $user = User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $Product = [
            "title"=> "Anything",
            "type"=> "Anything",
            "description"=> "Anything",
            "filename"=> "Anything",
            "height"=> "400",
            "width"=> "500",
            "price"=> "30.0",
            "rating"=> "4"
        ];
        Product::factory()->create($Product);
        $ProductUpdated = [
            "title"=> "NotAnything",
            "type"=> "NotAnything",
            "description"=> "NotAnything",
            "price"=> "31.0",
            "rating"=> "5"
        ];
        $this->actingAs($user,'api')->put('api/products/1',$ProductUpdated)->assertStatus(200);


    }
    public  function testUpdateProductWithUnexpectedData(){
        $user = User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $Product = [
            "title"=> "Anything",
            "type"=> "Anything",
            "description"=> "Anything",
            "filename"=> "Anything",
            "height"=> "400",
            "width"=> "500",
            "price"=> "30.0",
            "rating"=> "4"
        ];
        Product::factory()->create($Product);
        $ProductUpdated = [
            "title"=> "NotAnything",
            "type"=> "NotAnything",
            "description"=> "NotAnything",
            "price"=> "31.0"
        ];
        $this->actingAs($user,'api')->put('api/products/1',$ProductUpdated)->assertStatus(302);


    }
    public  function testFindProductWithExistingId(){
        $user = User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $Product = [
            "title"=> "Anything",
            "type"=> "Anything",
            "description"=> "Anything",
            "filename"=> "Anything",
            "height"=> "400",
            "width"=> "500",
            "price"=> "30.0",
            "rating"=> "4"
        ];
        Product::factory()->create($Product);
        $this->actingAs($user,'api')->get('api/products/1')->assertOk()->assertSee($Product);
    }
    public  function testFindProductWithNotExistingId(){
        $user = User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $this->actingAs($user,'api')->get('api/products/1')->assertStatus(500);

    }
    public  function testDeleteProductWithExistingId(){
        $user = User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $Product = [
            "title"=> "Anything",
            "type"=> "Anything",
            "description"=> "Anything",
            "filename"=> "Anything",
            "height"=> "400",
            "width"=> "500",
            "price"=> "30.0",
            "rating"=> "4"
        ];
        Product::factory()->create($Product);
        $this->actingAs($user,'api')->delete('api/products/1')->assertOk();
        $this->actingAs($user,'api')->get('api/products/1')->assertStatus(500);
    }
    public  function testDeleteProductWithNotExistingId(){
        $user = User::factory()->create(['email' => 'carlos@gmail.com','password'=>bcrypt('1223')]);
        $this->actingAs($user,'api')->delete('api/products/1')->assertStatus(500);
    }





}
