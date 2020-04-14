<?php

namespace App\Eloquents;

class Faq extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'answer',
    ];
}
