<?php

namespace App\Infrastructure\Repositories\Product;

use App\Infrastructure\Repositories\Product\IProductRepository;

class ProductRepository implements IProductRepository
{
    public function getProduct(string $name): string
    {
        return $name;
    }
}

?>