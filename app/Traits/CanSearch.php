<?php

namespace App\Traits;

/**
 * This Trait Can Be Used with Any Model
 */
trait CanSearch
{
    /**
     * @param  $query
     * @param  $keyword
     * @param  array      $columns
     * @param  array      $relativeTables
     * @return mixed
     */
    public function scopeSearch($query, $keyword, $columns = [], $relativeTables = [])
    {
        if (empty($columns)) {
            $columns = array_except(
                Schema::getColumnListing($this->table), $this->guarded
            );
        }

        $query->where(function ($query) use ($keyword, $columns, $relativeTables) {
            foreach ($columns as $key => $column) {
                $clause = 0 == $key ? 'where' : 'orWhere';
                $query->$clause($column, 'LIKE', "%$keyword%");

                if (!empty($relativeTables)) {
                    $this->filterByRelationship($query, $keyword, $relativeTables);
                }
            }
        });

        return $query;
    }

    /**
     * @param  $query
     * @param  $keyword
     * @param  $relativeTables
     * @return mixed
     */
    private function filterByRelationship($query, $keyword, $relativeTables)
    {
        foreach ($relativeTables as $relationship => $relativeColumns) {
            $query->orWhereHas($relationship, function ($relationQuery) use ($keyword, $relativeColumns) {
                foreach ($relativeColumns as $key => $column) {
                    $clause = 0 == $key ? 'where' : 'orWhere';
                    $relationQuery->$clause($column, 'LIKE', "%$keyword%");
                }
            });
        }

        return $query;
    }
}
