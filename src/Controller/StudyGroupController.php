<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\StudyGroup;
use App\Repository\StudentRepository;
use App\Repository\StudyGroupRepository;
use App\Traits\Pagination;
use App\Utils\Filter\Base\FilterBase;
use App\Utils\Filter\QueryFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StudyGroupController extends AbstractController
{
    use Pagination;

    /**
     * @Route("/groups/list", name="groups.list")
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page', 1);
        $objs = $this->paginate(StudyGroup::class, $request, NULL);

        $objs = [
            'stats' => [
                'total' => $this->pagerfanta->count()
            ],
            'data' => $objs
        ];

        return new JsonResponse($objs);
    }

    /**
     * @Route("/groups/list/simple", name="groups.list")
     * @param Request $request
     * @return JsonResponse
     */
    public function indexSimple(Request $request)
    {
        $queryFilter = new QueryFilter($request, new FilterBase());
        $objs = $this->makeArray($queryFilter->handle($this->getDoctrine()->getRepository(StudyGroup::class)), FALSE);

        $objs = [
            'data' => $objs
        ];

        return new JsonResponse($objs);
    }
}
