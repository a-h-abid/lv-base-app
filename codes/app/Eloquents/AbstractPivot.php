<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AbstractPivot extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
