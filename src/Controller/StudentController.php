<?php


namespace App\Controller;

use App\Entity\Student;
use App\Entity\Town;
use App\Repository\StudentRepository;
use App\Repository\StudyGroupRepository;
use App\Repository\TownRepository;
use App\Traits\Pagination;
use App\Traits\StudentTrait;
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
    use Pagination, Validator;
    use StudentTrait;



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
     * @Route("/students/{id}", name="students.get", requirements={"id"="\d+"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getStudentData(Request $request, StudentRepository $studentRepository)
    {
        $id = $request->get('id');
        $student = $studentRepository->find($id);
        if($student === NULL)
        {
            return new JsonResponse(['error' => TRUE], 400);
        }
        $array = $student->toArray();

        return new JsonResponse($this->cleanNormalizeArray($array));
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
        $student = new Student();

        $town = $this->getTown($request, $townRepository, $em);
        $student = $this->makeStudent($student, $request, $town);
        $this->addGroups($request, $student, $studyGroupRepository);

        $errorList = $this->validate($student, $validator);
        $data = [
            'errors' => $errorList,
            'message' => NULL
        ];


        if(count($errorList) === 0)
        {
            $em->persist($student);
            $em->flush();
        }

        return new JsonResponse($data, count($errorList) > 0 ? 400 : 200);
    }

    /**
     * @Route("/api/students/edit/{id}", name="api.students.edit", requirements={"id"="\d+"}, methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param TownRepository $townRepository
     * @param StudyGroupRepository $studyGroupRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function editStudent(Request $request,
                                   ValidatorInterface $validator,
                                   StudentRepository $studentRepository,
                                   TownRepository $townRepository,
                                   StudyGroupRepository $studyGroupRepository,
                                   EntityManagerInterface $em)
    {
        $id = $request->get('id');
        $student = $studentRepository->find($id);
        if($student === NULL)
        {
            return new JsonResponse(['error' => TRUE], 400);
        }

        $town = $this->getTown($request, $townRepository, $em);
        $student = $this->makeStudent($student, $request, $town);
        $this->addGroups($request, $student, $studyGroupRepository);

        $errorList = $this->validate($student, $validator);
        if($student->getGroups()->count() > 4)
        {
            $errorList[] = "Maximum 4 study group per user.";
        }
        $data = [
            'errors' => $errorList,
            'message' => NULL
        ];


        if(count($errorList) === 0)
        {
            $em->persist($student);
            $em->flush();
        }

        return new JsonResponse($data, count($errorList) > 0 ? 400 : 200);
    }


    /**
     * @Route("/api/students/delete/{id}", name="api.students.delete", requirements={"id"="\d+"}, methods={"DELETE"})
     * @return JsonResponse
     */
    public function deleteStudent(Request $request,
                                   ValidatorInterface $validator,
                                   StudentRepository $studentRepository,
                                   TownRepository $townRepository,
                                   StudyGroupRepository $studyGroupRepository,
                                   EntityManagerInterface $em)
    {
        $id = $request->get('id');
        $student = $studentRepository->find($id);
        if($student === NULL)
        {
            return new JsonResponse(['error' => TRUE], 400);
        }

        $this->removeStudentGroups($student);
        $this->removeStudentLeadGroups($student);

        $em->remove($student);
        $em->flush();

        return new JsonResponse(['error' => FALSE], 200);
    }


}