<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Phpro\ApiProblem\Exception\ApiProblemException;
use Phpro\ApiProblem\Http\HttpApiProblem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class MeController extends AbstractController
{
    #[Route('/api/me', name: 'api.me', defaults: ['_format' => 'json'])]
    public function __invoke(): JsonResponse
    {
        $user = $this->getUser();

        if (null === $user) {
            throw new ApiProblemException(new HttpApiProblem(JsonResponse::HTTP_UNAUTHORIZED, []));
        }

        return new JsonResponse($user);
    }
}
