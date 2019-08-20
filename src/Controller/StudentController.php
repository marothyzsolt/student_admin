<?php


namespace App\Controller;

use App\Entity\Student;
use App\Traits\Pagination;
use App\Utils\Filter\Filters\StudentFilter;
use App\Utils\Filter\QueryFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class StudentController extends AbstractController
{
    use Pagination;

    /**
     * @Route("/students/list", name="students.list")
     * @param Request $request
     * @return
     */
    public function index(Request $request)
    {
        $objs = $this->paginate(Student::class, $request, new StudentFilter());

        $objs = [
            'stats' => [
                'total' => $this->pagerfanta->count()
            ],
            'data' => $objs
        ];

        return new JsonResponse($objs);
    }


}