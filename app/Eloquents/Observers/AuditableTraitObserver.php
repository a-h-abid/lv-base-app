<?php

namespace App\Eloquents\Observers;

use Illuminate\Database\Eloquent\Model;

class AuditableTraitObserver
{
    public function creating(Model $model)
    {
        if (! $model->created_by) {
            $model->created_by = $this->getAuthenticatedUserId($model);
        }

        if (! $model->updated_by) {
            $model->updated_by = $this->getAuthenticatedUserId($model);
        }
    }

    public function updating(Model $model)
    {
        if (! $model->isDirty('updated_by')) {
            $model->updated_by = $this->getAuthenticatedUserId($model);
        }
    }

    /**
     * Get authenticated user id depending on model's auth guard.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return int|null
     */
    protected function getAuthenticatedUserId($model)
    {
        return auth($model->getAuditableAuthGuardName())->check() ? auth($model->getAuditableAuthGuardName())->id() : null;
    }
}