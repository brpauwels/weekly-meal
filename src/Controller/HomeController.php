<?php

declare(strict_types=1);

namespace App\Controller;

use DateTimeImmutable;
use League\Period\Period;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function __invoke(): Response
    {
        $now    = new DateTimeImmutable('now');
        $period = Period::fromIsoWeek((int) $now->format('Y'), (int) $now->format('W'));

        /** @var Period[] $days */
        $days = [];
        foreach ($period->split('1 DAY') as $day) {
            $days[] = $day;
        }

        return $this->render('home/index.html.twig', ['days' => $days]);
    }
}
