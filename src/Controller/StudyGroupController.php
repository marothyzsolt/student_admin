<?php

namespace App\Controller;

use App\Entity\StudyGroup;
use App\Repository\StudyGroupRepository;
use App\Traits\Pagination;
use App\Utils\Filter\Base\FilterBase;
use App\Utils\Filter\Filters\StudyGroupFilter;
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
        $objs = $this->paginate(StudyGroup::class, $request, new StudyGroupFilter());

        $objs = [
            'stats' => [
                'total' => $this->pagerfanta->count()
            ],
            'data' => $objs
        ];

        return new JsonResponse($objs);
    }

    /**
     * @Route("/groups/list/simple", name="groups.list.simple")
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

    /**
     * @Route("/groups/{id}", name="groups.get")
     * @param Request $request
     * @return JsonResponse
     */
    public function getGroup(Request $request, StudyGroupRepository $studyGroupRepository)
    {
        $id = $request->get('id');
        dd($studyGroupRepository->find($id));
        return new JsonResponse($studyGroupRepository->find($request->get('id')));
    }
}
