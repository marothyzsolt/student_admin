<?php


namespace App\Controller;

use App\Entity\Student;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class StudentController extends AbstractController
{

    /**
     * @Route("/students/list", name="students.list")
     * @param Request $request
     * @return
     */
    public function index(Request $request)
    {

        $page = $request->query->get('page', 1);
        $qb = $this->getDoctrine()
            ->getRepository(Student::class)
            ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);
        $pagerfanta->setCurrentPage($page);
        $objs = [];
        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $objs[] = $result->toArray();
        }

        //dd($objs[0]);
        //$students = $studentRepository->findAll();

        //dd($students);

        $objs = [
            'stats' => [
                'total' => $pagerfanta->count()
            ],
            'data' => $objs
        ];

        return new JsonResponse($objs);

        //dd($students[0]->toArray());
       // return new JsonResponse($students->toArray());
    }


}