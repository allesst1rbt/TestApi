<?php

namespace App\Repositories;

interface ProductsRepositoryInterface
{
    public function getProducts(): object;

    public function createProduct($data): void;

    public function updateProductById($id, $data): void;

    public function findProductById($id): object;

    public function deleteProductById($id): void;
}
