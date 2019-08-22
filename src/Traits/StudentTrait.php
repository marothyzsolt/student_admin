<?php


namespace App\Traits;


use App\Entity\Student;
use App\Entity\Town;
use App\Repository\StudyGroupRepository;
use App\Repository\TownRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

trait StudentTrait
{
    protected function getTown(Request $request, TownRepository $townRepository, EntityManagerInterface $em) : Town
    {
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

        return $town;
    }

    protected function makeStudent(Student $student, Request $request, Town $town) : Student
    {
        $student->setName($request->get('name'));
        $student->setEmail($request->get('email'));
        $student->setSex($request->get('sex')==1);
        $student->setTown($town);

        return $student;
    }

    protected function removeStudentGroups(Student $student) : void
    {
        if(count($student->getGroups()) > 0) {
            foreach ($student->getGroups() as $index => $group) {
                $student->removeGroup($group);
            }
        }
    }

    protected function removeStudentLeadGroups(Student $student) : void
    {
        if(count($student->getLeadGroups()) > 0) {
            foreach ($student->getLeadGroups() as $index => $group) {
                $student->removeLeadGroup($group);
            }
        }
    }

    protected function addGroups(Request $request, Student $student, StudyGroupRepository $studyGroupRepository) : void
    {
        $groups = $request->get('group');

        $this->removeStudentGroups($student);

        if(is_array($groups) && count($groups) > 0) {
            foreach ($groups as $index => $grpId) {
                $studyGroup = $studyGroupRepository->find($grpId);
                if($studyGroup !== NULL) {
                    $student->addGroup($studyGroup);
                }
            }
        }
    }
}