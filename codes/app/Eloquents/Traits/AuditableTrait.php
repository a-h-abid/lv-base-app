<?php

namespace App\Eloquents\Traits;

use App\Eloquents\Observers\AuditableTraitObserver;
use Illuminate\Database\Eloquent\Builder;

trait AuditableTrait
{
    /**
     * Boot the audit trait for a model.
     *
     * @return void
     */
    public static function bootAuditableTrait()
    {
        static::observe(new AuditableTraitObserver);
    }

    /**
     * Get user model who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo($this->getRelatedUserModelInstance(), $this->getCreatedByColumn());
    }

    /**
     * Get column name for created by.
     *
     * @return string
     */
    protected function getCreatedByColumn()
    {
        return 'created_by';
    }

    /**
     * Get user model who updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo($this->getRelatedUserModelInstance(), $this->getUpdatedByColumn());
    }

    /**
     * Get column name for updated by.
     *
     * @return string
     */
    protected function getUpdatedByColumn()
    {
        return 'updated_by';
    }

    /**
     * Get created by user full name.
     *
     * @return string
     */
    public function getCreatedByNameAttribute()
    {
        if ($this->{$this->getCreatedByColumn()}) {
            return $this->creator->name;
        }
        return '';
    }

    /**
     * Get Laravel's user class instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getRelatedUserModelInstance()
    {
        $class = config('auth.providers.users.model');

        return new $class;
    }

    /**
     * Get auth guard name.
     *
     * @return string
     */
    public function getAuditableAuthGuardName()
    {
        return config('auth.defaults.guard');
    }

    /**
     * Get updated by user name.
     *
     * @return string
     */
    public function getUpdatedByNameAttribute()
    {
        if ($this->{$this->getUpdatedByColumn()}) {
            return $this->updater->name;
        }
        return '';
    }

    /**
     * Query scope to limit results to own records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwned(Builder $query)
    {
        return $query->where($this->getQualifiedUserIdColumn(), auth($this->getAuditableAuthGuardName())->id());
    }

    /**
     * Get qualified column name for user id.
     *
     * @return string
     */
    public function getQualifiedUserIdColumn()
    {
        return $this->getTable() . '.' . $this->getRelatedUserModelInstance()->getKey();
    }
}