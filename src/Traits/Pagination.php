<?php


namespace App\Traits;


use App\Utils\Filter\Base\FilterBase;
use App\Utils\Filter\QueryFilter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

trait Pagination
{
    protected $pagerfanta;

    protected function paginate(string $class, Request $request, ?FilterBase $filter, bool $recursive = true) : array
    {
        if($filter === NULL) {
            $queryFilter = new QueryFilter($request, new FilterBase());
        }
        if($filter !==  NULL) {
            $queryFilter = new QueryFilter($request, $filter);
            $queryFilter->handle($this->getDoctrine()->getRepository($class));
            $this->pagerfanta = $queryFilter->getPagerfanta();
        }

        return $this->makeArray($queryFilter->getPagination(), $recursive);
    }

    protected function makeArray($items, bool $recursive = true) : array
    {
        $objs = [];
        foreach ($items as $result) {
            $objs[] = $result->toArray($recursive);
        }

        return $this->cleanNormalizeArray($objs);
    }

    private function cleanNormalizeArray(&$items)
    {
        if(is_array($items))
        {
            foreach ($items as $index => &$item)
            {
                if(is_array($item)) {
                    $this->cleanNormalizeArray($item);
                }
                else if(is_object($item)) {
                    if($item instanceof \DateTime) {
                        $item = $item->format('Y-m-d H:i:s');
                    } else {
                        unset($items[$index]);
                    }
                }
                else if (strpos($index, '__') === 0) {
                    unset($items[$index]);
                }
            }
        }
        return $items;
    }
}