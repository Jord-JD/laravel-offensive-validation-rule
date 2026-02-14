<?php

namespace JordJD\LaravelOffensiveValidationRule;

use JordJD\IsOffensive\OffensiveChecker;
use Illuminate\Contracts\Validation\Rule;

class Offensive implements Rule
{
    private $offensiveChecker;

    public function __construct(OffensiveChecker $offensiveChecker = null)
    {
        if (!$offensiveChecker) {
            $offensiveChecker = new OffensiveChecker();
        }

        $this->offensiveChecker = $offensiveChecker;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !$this->offensiveChecker->isOffensive($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This :attribute is not allowed.';
    }
}
