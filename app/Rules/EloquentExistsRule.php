<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentExistsRule implements Rule
{
    /**
     * The model to run the query against.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The column to check on.
     *
     * @var string
     */
    protected $column;

    /**
     * Create a new rule instance.
     *
     * @param  string|Model  $model
     * @param  string  $column
     * @return void
     */
    public function __construct($model, $column = 'id')
    {
        if (is_string($model)) {
            $model = app($model);
        }

        if (!($model instanceof Model)) {
            $modelClass = get_class($model);
            throw new \InvalidArgumentException("The provided model class {$modelClass} is not an eloquent model.");
        }

        $this->model = $model->newQuery();
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->model->where($this->column, '=', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute does not exists.';
    }

    /**
     * Callback on model's builder
     *
     * It passes an Illuminate\Database\Eloquent\Builder
     * instance in the closure
     *
     * @param  string $scopeName
     * @return $this
     */
    public function callback(\Closure $callback)
    {
        $this->model = $callback($this->model);

        if (!($this->model instanceof Builder)) {
            throw new \RuntimeException("Query Callback did not returned an eloquent builder.");
        }

        return $this;
    }
}
