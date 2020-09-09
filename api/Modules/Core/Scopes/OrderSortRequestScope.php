<?php

namespace Modules\Core\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Input;

class OrderSortRequestScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $order = Input::get('order', null);
        if (!empty($order)) {
            $sort = Input::get('sort', 'asc');
            $direction = (!empty($sort) && in_array($sort, ['asc', 'desc'])) ? $sort : 'asc';
            $builder->orderBy($order, $direction);
        }
    }
}
