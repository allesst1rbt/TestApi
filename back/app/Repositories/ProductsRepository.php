<?php


namespace App\Repositories;


use App\Jobs\CreateProductAsync;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;


class ProductsRepository implements ProductsRepositoryInterface
{
    public function  getProducts(): object
    {
        return Product::paginate(10);
    }
    public function createProduct($data): void
    {
        dispatch(new CreateProductAsync($data))->onQueue('createProducts');
    }
    public function updateProductById($id, $data): void
    {

        $product = Product::find($id);
        if(empty($product)){
            throw new \Exception("Error on Update product");
        }
        $product->title = $data->title;
        $product->type = $data->type;
        $product->description = $data->description;
        $product->price = $data->price;
        $product->rating = $data->rating;
        $product->save();
    }
    public function findProductById($id): object
    {
        $product= Product::find($id);
        if(empty($product)){
            throw new \Exception('Error on search product');
        }
        return $product;

    }
    public function deleteProductById($id): void
    {
        $product= Product::find($id);
        if(empty($product)){
            throw new \Exception('Error on delete product');
        }
        $product->delete();

    }
}
