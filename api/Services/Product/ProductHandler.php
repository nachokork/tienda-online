<?php

class ProductHandler
{
    public function __construct(
      protected \App\Repository\Product\ProductRepository $productRepository,
    ){}
    public function getAllProducts()
    {
        return $this->productRepository->getProducts();
    }
}