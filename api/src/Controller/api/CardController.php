<?php

namespace App\Controller\api;

use App\Entity\Card;
use App\Repository\CardRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    public function __construct(
        public CardRepository $cardRepository,
        public UserRepository $userRepository,
        public ProductRepository $productRepository,
    )
    {}
    #[Route('/api/cart', name: 'card', methods: ['GET'])]
    public function getCard()
    {
        $products = $this->cardRepository->findAll();
        return $this->json($products);
    }

    #[Route('/api/add/products', name: 'add_product_card', methods: ['PUT'])]
    public function addProductToCard(Request $request): JsonResponse
    {
        $requestContent = json_decode($request->getContent(), true);
        $user = $this->userRepository->findOneBy(['email' => $requestContent['email']]);
        $product = $this->productRepository->findOneBy(['id' => $requestContent['id']]);

        $card = $this->cardRepository->findOneByUser($user);

        if (!$card) {
            $card = new Card();
            $card->setUserItem($user);
        }

        $card->addProduct($product);
        $this->cardRepository->save($card, true);

        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/productcard/{id}', name: 'delete_product_card', methods: ['DELETE'])]
    public function removeProduct($id): JsonResponse
    {
        $card = $this->cardRepository->findOneBy(['id' => $id]);
        $this->cardRepository->delete($card);
        return new JsonResponse(["succes" => 200]);
    }
}