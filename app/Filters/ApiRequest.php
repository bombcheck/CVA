<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;


class ApiRequest
{

    /**
     * @param $filters
     * @param $includes
     * @param $entity
     * @return Builder
     */
    public static function applyQuery($filters,$includes,$entity)
    {
        $query = QueryBuilder::for($entity)
            ->allowedIncludes($includes)
            ->allowedFilters(self::constructFilters($filters));
        return $query;
    }

    /**
     *  Construct Filters
     * @param $filters
     * @return array
     */
    private static function constructFilters($filters){
        if($filters == [])
            return $filters;
        $exact = [];
        $custom = [];
        foreach ($filters['exact'] as $filter) {
            $exact[] = Filter::exact($filter);
        }
        if(array_key_exists('custom',$filters)){
            foreach ($filters['custom'] as $key=>$value) {
                $custom[] = Filter::custom($key,$value);
            }
        }
        return  array_merge($exact,$filters['partial'], $custom);
    }

}
