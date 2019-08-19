<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="stats")
     */
    public function index()
    {
        $stats = [
            'students_total' => 123,
            'groups_total' => 12,
            'students_in_groups' => 10
        ];
        return new JsonResponse($stats);
    }
}
