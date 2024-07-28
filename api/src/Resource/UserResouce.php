<?php

namespace App\Resource;

use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class UserResource
{
    public static function getResource(User $user, $token = null): array
    {
        $resource = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];

        if ($token) {
            $resource['token'] = $token;
        }

        return $resource;
    }

    public static function getCollection(array|Collection $users): array
    {
        //chek if $tales is an array or a collection
        return (is_array($users))
            ? array_map(fn($user) => self::getResource($user), $users)
            : $users->map(fn($user) => self::getResource($user))->toArray();
    }
}
