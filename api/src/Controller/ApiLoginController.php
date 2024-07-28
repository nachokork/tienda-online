<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Resource\UserResource;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


class ApiLoginController extends AbstractController
{
    public function __construct(
        protected JWTEncoderInterface $jwtEncoder,
        protected UserRepository $userRepository,
        protected UserPasswordHasherInterface $passwordHasher,
    ){}

    #[Route('/api/login', name: 'login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->userRepository->findOneBy(['email' => $data['email']]);
        if (!$user) {
            return $this->json([
                'message' => 'LogInError1'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$this->passwordHasher->isPasswordValid($user, $data['password'])) {
            return $this->json([
                'message' => 'LogInError2'
            ], Response::HTTP_NOT_FOUND);
        }

        $token = $this->jwtEncoder->encode([
            'email' => $user->getEmail(),
            'exp' => time() + (61 * 24 * 60 * 60) // 2 months expiration
        ]);
        return $this->json(
            UserResource::getResource($user, $token)
        );
    }
}
