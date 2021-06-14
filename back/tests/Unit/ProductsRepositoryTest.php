<?php

namespace Tests\Unit;

use App\Jobs\CreateProductAsync;
use App\Models\Product;
use App\Repositories\ProductsRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductsRepositoryTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        Queue::fake();
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
        $productRepository = new ProductsRepository();
        $productRepository->createProduct($Product);
        Queue::assertPushedOn('createProducts', CreateProductAsync::class);

    }
    public function testFindProductByExistingId(){
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
        $product = Product::factory()->create($Product);
        $productRepository = new ProductsRepository();
        $productFromDb = $productRepository->findProductById(1)->toArray();

        $this->assertEquals($product->getAttributes(),$productFromDb);
    }
    public function testFindProductByNotExistingId(){
        $this->expectExceptionMessage('Error on search product');
        $productRepository = new ProductsRepository();
        $productRepository->findProductById(1);

    }
    public function testDeleteProductByExistingId(){
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
        $productRepository = new ProductsRepository();
        $productRepository->deleteProductById(1);
        $this->expectExceptionMessage('Error on search product');
        $productRepository->findProductById(1);

    }
    public function testDeleteProductByNotExistingId(){
        $this->expectExceptionMessage('Error on delete product');
        $productRepository = new ProductsRepository();
        $productRepository->deleteProductById(1);

    }

    /**
     * @throws \Exception
     */
    public function testUpdateProductByExistingId(){
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
        $product =Product::factory()->create($Product);
        $ProductUpdated = [
            "title"=> "NotAnything",
            "type"=> "NotAnything",
            "description"=> "NotAnything",
            "price"=> "31.0",
            "rating"=> "4"
        ];
        $productRepository = new ProductsRepository();
        $productRepository->updateProductById(1,(object)$ProductUpdated);
        $productFromDb = $productRepository->findProductById(1)->toArray();
        $this->assertNotEquals($product,$productFromDb);
    } public function testUpdateProductByNotExistingId(){
         $this->expectExceptionMessage('Error on Update product');
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
            "rating"=> "4"
        ];
        $productRepository = new ProductsRepository();
        $productRepository->updateProductById(2,(object)$ProductUpdated);

    }
}
