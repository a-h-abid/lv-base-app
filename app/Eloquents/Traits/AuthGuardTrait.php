<?php

namespace App\Eloquents\Traits;

trait AuthGuardTrait
{
    /**
     * Get Guard Name
     *
     * @return string
     */
    public function getGuardName()
    {
        return $this->guardName;
    }

    /**
     * Get Password Hash Field Name
     *
     * @return string
     */
    public function getPasswordHashFieldName()
    {
        return 'password_hash_'.$this->getGuardName();
    }
}