<?php

namespace Webkul\Core\Contracts\Validations;

use Illuminate\Contracts\Validation\Rule;

class Slug implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[A-Za-z0-9_-,.]*$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('core::validation.slug');
    }
}