<?php

namespace App\Http\Controllers;

use App\Repositories\ProductsRepository;

use App\Repositories\ProductsRepositoryInterface;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class ProductsController extends Controller
{
    private $productsRepositoryInterface;
    public function __construct(ProductsRepositoryInterface $productsRepositoryInterface)
    {
        $this->productsRepositoryInterface= $productsRepositoryInterface;
    }

    public function index():\Illuminate\Http\JsonResponse{
        try {
            $products = $this->productsRepositoryInterface->getProducts();
            return response()->json(['message'=>'dados recuperados com sucesso','data'=>$products]);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception],502);
        }
    }
    public function store (Request $request)//: \Illuminate\Http\JsonResponse
    {
        $request->validate([
            "*.title"=> "Required|string",
            "*.type"=> "Required|string",
            "*.description"=> "Required|string",
            "*.filename"=> "Required|string",
            "*.height"=> "Required|int",
            "*.width"=> "Required|int",
            "*.price"=> "required|regex:/^\d+(\.\d{1,2})?$/",
            "*.rating"=> "Required|int"
        ]);
        try {
            foreach ($request->all() as $product){
                $this->productsRepositoryInterface->createProduct($product);
            }
            return response()->json(['message'=>"produtos cadastrados com sucesso"]);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception],502);
        }
    }

    public function  show($id): \Illuminate\Http\JsonResponse{
        try {
            $product = $this->productsRepositoryInterface->findProductById($id);
            return response()->json(['message'=>'dados recuperados com sucesso','data'=>$product]);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception],502);
        }
    } public function  destroy($id): \Illuminate\Http\JsonResponse{
        try {
            $this->productsRepositoryInterface->deleteProductById($id);
            return response()->json(['message'=>'produto deletado com sucesso']);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception],502);
        }
    }
    public function  update($id,Request $request): \Illuminate\Http\JsonResponse{
        $request->validate([
            "title"=> "required|string",
            "type"=> "required|string",
            "description"=> "required|string",
            "price"=> "required|regex:/^\d+(\.\d{1,2})?$/",
            "rating"=> "required|int"
        ]);
        try {
            $this->productsRepositoryInterface->updateProductById($id,$request);
            return response()->json(['message'=>"produto $request->title atualizado com sucesso"]);
        }catch (Exception $exception){
            return response()->json(['error'=>$exception],502);
        }
    }
}
