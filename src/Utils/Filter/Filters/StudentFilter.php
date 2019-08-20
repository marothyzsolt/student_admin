<?php


namespace App\Utils\Filter\Filters;


use App\Utils\Filter\Base\FilterBase;
use Doctrine\ORM\QueryBuilder;

class StudentFilter extends FilterBase
{
    public function group(QueryBuilder $queryBuilder, array $groups) : QueryBuilder
    {

        $queryBuilder
            ->leftJoin('App:GroupStudent', 'gs', 'WITH', 'gs.student = t.id')
            ->leftJoin('App:StudyGroup', 'sg', 'WITH', 'sg.id = gs.group');

        foreach ($groups as $index => $group) {
            $queryBuilder = $queryBuilder->orWhere('sg.id = :group_id_'.$index)->setParameter('group_id_'.$index, $group);
        }
        return $queryBuilder;
    }

    public function name(QueryBuilder $queryBuilder, string $name) : QueryBuilder
    {
        return $queryBuilder->orWhere('t.name LIKE :name')->setParameter('name', "%$name%");
    }
}