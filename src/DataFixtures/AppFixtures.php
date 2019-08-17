<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Student;
use App\Entity\StudyGroup;
use App\Entity\Subject;
use App\Entity\Town;
use App\Repository\StudentRepository;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends BaseFixture
{
    private $subjects = ['Art', 'Citizenship', 'Geography', 'History', 'Literacy', 'Science', 'Arithmetic', 'Mathematics', 'Biology', 'Chemistry', 'Physics', 'Web design'];

    public function loadData(ObjectManager $manager) : void
    {
        $this->loadImages();
        $this->loadTowns();
        $this->loadStudents();
        $this->loadSubjects();
        $this->loadGroups();
        $this->loadAttachUsersToGroups($manager);

        $manager->flush();
    }


    private function loadTowns() : void
    {
        $this->createMany(Town::class, 30, function(Town $obj) {
            $obj->setName($this->faker->unique()->city);
            $obj->setZip($this->faker->unique()->postcode);
        });
    }

    private function loadStudents() : void
    {
        $this->createMany(Student::class, 25, function(Student $obj) {
            $sex = $this->faker->boolean;
            $name = $sex ? $this->faker->firstName('male'). ' ' . $this->faker->firstName('male') : $this->faker->lastName('female'). ' ' . $this->faker->firstName('female');

            $obj->setName($name);
            $obj->setEmail($this->faker->freeEmail);
            $obj->setSex($sex);
            $obj->setBirthDate($this->faker->dateTimeBetween('-20 years', '-10 years'));
            $obj->setTown($this->getRandomReference(Town::class));
            $obj->setProfileImage($this->getRandomReference(Image::class));
        });
    }

    private function loadImages() : void
    {
        $this->createMany(Image::class, 50, function(Image $obj) {
            $obj->setPath($this->faker->imageUrl(300, 300, 'people'));
            $obj->setType(2);
        });
    }

    private function loadSubjects() : void
    {
        foreach ($this->subjects as $index => $subject) {
            $this->create(Subject::class, function(Subject $obj) use ($subject) {
                $obj->setName($subject);
                $obj->setCode(strtoupper($this->faker->randomLetter.''.$this->faker->numberBetween(1000,9999)));
            });
        }
    }

    private function loadGroups() : void
    {
        $this->createMany(StudyGroup::class, 30, function(StudyGroup $obj) {
            $obj->setLeader($this->getRandomReference(Student::class));
            $obj->setSubject($this->getRandomReference(Subject::class));
            $obj->setName($this->faker->sentence(2));
        });
    }

    private function loadAttachUsersToGroups(ObjectManager $manager) : void
    {
        for($i = 0; $i < 40; $i++) {
            /** @var Student $student */
            $student = $this->getRandomReference(Student::class);
            $student->addGroup($this->getRandomReference(StudyGroup::class));

            $manager->persist($student);
        }

    }
}
