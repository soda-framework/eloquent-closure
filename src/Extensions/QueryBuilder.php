<?php

namespace Soda\ClosureTable\Extensions;

use Illuminate\Database\Query\Builder as BaseQueryBuilder;

/**
 * Extended Query Builder.
 */
class QueryBuilder extends BaseQueryBuilder
{
    /**
     * Builds "where position" query part based on given values.
     *
     * @param string $column
     * @param array $values
     * @return $this
     */
    public function buildWherePosition($column, array $values)
    {
        if (count($values) == 1 || is_null($values[1])) {
            $this->where($column, '>=', $values[0]);
        } else {
            $this->whereIn($column, range($values[0], $values[1]));
        }

        return $this;
    }
}
