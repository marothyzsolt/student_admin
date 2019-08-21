<?php


namespace App\Controller;

use App\Entity\Subject;
use App\Traits\Pagination;
use App\Utils\Filter\Base\FilterBase;
use App\Utils\Filter\Filters\SubjectFilter;
use App\Utils\Filter\QueryFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SubjectController extends AbstractController
{
    use Pagination;

    /**
     * @Route("/subjects/list", name="subjects.list")
     * @param Request $request
     * @return
     */
    public function index(Request $request)
    {
        $objs = $this->paginate(Subject::class, $request, new SubjectFilter());

        $objs = [
            'stats' => [
                'total' => $this->pagerfanta->count()
            ],
            'data' => $objs
        ];

        return new JsonResponse($objs);
    }

    /**
     * @Route("/subjects/list/simple", name="subjects.list.simple")
     * @param Request $request
     * @return JsonResponse
     */
    public function indexSimple(Request $request)
    {
        $queryFilter = new QueryFilter($request, new FilterBase());
        $objs = $this->makeArray($queryFilter->handle($this->getDoctrine()->getRepository(Subject::class)), FALSE);

        $objs = [
            'data' => $objs
        ];

        return new JsonResponse($objs);
    }
}