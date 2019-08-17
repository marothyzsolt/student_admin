<?php


namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /** @var Generator */
    protected $faker;
    private $referencesIndex = [];

    abstract public function loadData(ObjectManager $manager) : void;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create('hu_HU');

        $this->loadData($manager);
    }

    protected function getRandomReference(string $className) {
        if (!isset($this->referencesIndex[$className])) {
            $this->referencesIndex[$className] = [];

            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
                if (strpos($key, $className.'_') === 0) {
                    $this->referencesIndex[$className][] = $key;
                }
            }
        }
        if (empty($this->referencesIndex[$className])) {
            throw new \Exception(sprintf('Cannot find any references for class "%s"', $className));
        }
        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$className]);
        return $this->getReference($randomReferenceKey);
    }

    protected function createMany(string $className, int $count, callable $factory) : void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->create($className, $factory, $i);
        }
    }

    protected function create(string $className, callable $factory, $index = NULL) : void
    {
        if($index === NULL) {
            $index = rand(0,999999);
        }

        $entity = new $className();
        $factory($entity);
        $this->manager->persist($entity);
        $this->addReference($className . '_' . $index, $entity);
    }
}