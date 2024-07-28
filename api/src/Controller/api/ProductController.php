<?php

namespace App\Controller\api;

use App\Entity\Product;
use App\Repository\Product\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        public ProductRepository $productRepository,
    )
    {}

    #[Route('/api/products', name: 'products', methods: ['GET'])]
    public function getProducts()
    {
        $products = $this->productRepository->findAll();
        return $this->json($products);
    }

    #[Route('/api/products', name: 'add_product', methods: ['PUT'])]
    public function addProduct(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);
        $product = new Product();
        $product->setName($requestContent['name']);
        $product->setDescription($requestContent['description']);
        $product->setPrice($requestContent['price']);
        $product->setStock($requestContent['stock']);
        return $this->json($this->productRepository->save($product));
    }

    #[Route('/api/products/{id}', name: 'delete_product', methods: ['DELETE'])]
    public function removeProduct($id): JsonResponse
    {
        return $this->productRepository->deleteProductById($id);
    }

}