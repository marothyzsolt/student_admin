<?php


namespace App\Utils\Filter;


use App\Utils\Filter\Base\FilterBase;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class QueryFilter
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var FilterInterface
     */
    private $filter;


    private $pagerfanta;


    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * QueryFilter constructor.
     * @param Request $request
     * @param FilterInterface $filter
     */
    public function __construct(Request $request, FilterBase $filter)
    {
        $this->request = $request;
        $this->filter = $filter;
    }

    public function handle($repository, $pagination = TRUE)
    {
        /** @var ParameterBag $parameterPag */
        $parameterPag = $this->request->query;

        $this->queryBuilder = $repository->createQueryBuilder('t');

        foreach ($parameterPag as $index => $item) {
            if(method_exists($this->filter, $index)) {
                if($item !== '') {
                    $this->queryBuilder = $this->filter->$index($this->queryBuilder, $item);
                }
            }
            else if($index === 'page') {
                if($item > 0) {
                    $this->makePagination($item);
                }
            }
        }
        if($this->pagerfanta === NULL && $pagination) {
            $this->makePagination(1);
        }

        return $this->queryBuilder->getQuery()->getResult();
    }

    private function makePagination($pageNumber)
    {
        $this->pagerfanta =
            (new Pagerfanta(new DoctrineORMAdapter($this->queryBuilder)))
                ->setMaxPerPage(10)
                ->setCurrentPage($pageNumber);
    }

    /**
     * @return mixed
     */
    public function getPagerfanta()
    {
        return $this->pagerfanta;
    }

    public function getPagination()
    {
        return $this->pagerfanta->getCurrentPageResults();
    }

}