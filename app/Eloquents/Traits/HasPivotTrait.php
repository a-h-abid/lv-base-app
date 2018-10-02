<?php

namespace App\Eloquents\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasPivotTrait
{
    /**
     * Check if Pivot contains the model
     *
     * @param  string $relation
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return boolean
     */
    public function hasPivot($relation, Model $model)
    {
        return (bool) $this->{$relation}()->wherePivot($model->getForeignKey(), $model->{$model->getKeyName()})->count();
    }
}