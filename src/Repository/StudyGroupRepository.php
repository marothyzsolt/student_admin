<?php

namespace App\Repository;

use App\Entity\StudyGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudyGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudyGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudyGroup[]    findAll()
 * @method StudyGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudyGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudyGroup::class);
    }

    // /**
    //  * @return StudyGroup[] Returns an array of StudyGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StudyGroup
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllQueryBuilder()
    {
        return $this->createQueryBuilder('student');
    }


    public function countGroups()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT count(study_group.id) FROM App:StudyGroup study_group'
        )->getSingleScalarResult();
    }
}
