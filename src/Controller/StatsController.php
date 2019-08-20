<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use App\Repository\StudyGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="stats")
     */
    public function index(StudentRepository $studentRepository, StudyGroupRepository $groupRepository)
    {
        $stats = [
            'students_total' => $studentRepository->countStudents(),
            'groups_total' => $groupRepository->countGroups(),
            'students_in_groups' => $studentRepository->countStudentsHasGroup()
        ];
        return new JsonResponse($stats);
    }
}
