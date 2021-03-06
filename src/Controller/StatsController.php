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
        $students = $studentRepository->countStudents();
        $groups = $groupRepository->countGroups();

        $stats = [
            'students_total' => $students,
            'students_page' => $students/10,
            'groups_total' => $groups,
            'groups_page' => $groups/10,
            'students_in_groups' => $studentRepository->countStudentsHasGroup()
        ];
        return new JsonResponse($stats);
    }
}
