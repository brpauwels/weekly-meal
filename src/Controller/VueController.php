<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function json_encode;

final class VueController extends AbstractController
{
    #[Route('/{vueRouting}', name: 'vue', defaults: ['vueRouting' => null], priority: -1)]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'vue/index.html.twig',
            [
                'isAuthenticated' => null !== $user,
                'user'            => json_encode($user),
            ]
        );
    }
}
