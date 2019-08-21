<?php


namespace App\Utils\Filter\Filters;


use App\Utils\Filter\Base\FilterBase;
use Doctrine\ORM\QueryBuilder;

class SubjectFilter extends FilterBase
{
    public function group(QueryBuilder $queryBuilder, array $groups) : QueryBuilder
    {
        return $queryBuilder;
    }

    public function name(QueryBuilder $queryBuilder, string $name) : QueryBuilder
    {
        return $queryBuilder->andWhere('t.name LIKE :name')->setParameter('name', "%$name%");
    }
}