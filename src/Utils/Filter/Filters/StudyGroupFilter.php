<?php


namespace App\Utils\Filter\Filters;


use App\Utils\Filter\Base\FilterBase;
use Doctrine\ORM\QueryBuilder;

class StudyGroupFilter extends FilterBase
{
    public function subject(QueryBuilder $queryBuilder, array $subject) : QueryBuilder
    {
        return $queryBuilder->andWhere('t.subject IN (:subjectList)')->setParameter('subjectList', $subject);
    }

    public function name(QueryBuilder $queryBuilder, string $name) : QueryBuilder
    {
        return $queryBuilder->andWhere('t.name LIKE :name')->setParameter('name', "%$name%");
    }
}