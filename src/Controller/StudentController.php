<?php


namespace App\Controller;

use App\Entity\Student;
use App\Entity\Town;
use App\Repository\StudyGroupRepository;
use App\Repository\TownRepository;
use App\Traits\Pagination;
use App\Traits\Validator;
use App\Utils\Filter\Filters\StudentFilter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class StudentController extends AbstractController
{
    use Pagination;
    use Validator;

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

    /**
     * @Route("/api/students/create", name="api.students.create", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param TownRepository $townRepository
     * @param StudyGroupRepository $studyGroupRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function create(Request $request,
                           ValidatorInterface $validator,
                           TownRepository $townRepository,
                           StudyGroupRepository $studyGroupRepository,
                           EntityManagerInterface $em)
    {
        $groups = $request->get('group');
        $town = $request->get('birth_place');
        $townEntity = $townRepository->findBy(['name' => $town]);
        if(count($townEntity) > 0) {
            $town = $townEntity[0];
        } else {
            $town = new Town();
            $town->setName($request->get('birth_place'));
            $town->setZip(rand(1000,9999));

            $em->persist($town);
        }

        $student = new Student();
        $student->setName($request->get('name'));
        $student->setEmail($request->get('email'));
        $student->setSex($request->get('sex')==1);
        $student->setTown($town);

        $errorList = $this->validate($student, $validator);
        $data = [
            'errors' => $errorList,
            'message' => NULL
        ];

        if(is_array($groups) && count($groups) > 0) {
            foreach ($groups as $index => $grpId) {
                $studyGroup = $studyGroupRepository->find($grpId);
                if($studyGroup !== NULL) {
                    $student->addGroup($studyGroup);
                }
            }
        }

        if(count($errorList) === 0)
        {
            $em->persist($student);
            $em->flush();
        }

        return new JsonResponse($data, count($errorList) > 0 ? 400 : 200);
    }


}