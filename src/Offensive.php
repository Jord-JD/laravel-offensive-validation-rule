<?php

namespace JordJD\LaravelOffensiveValidationRule;

use Illuminate\Contracts\Validation\Rule;
use JordJD\IsOffensive\OffensiveChecker;

class Offensive implements Rule
{
    /** @var OffensiveChecker */
    private $offensiveChecker;

    /** @var string */
    private $validationMessage;

    public function __construct(
        ?OffensiveChecker $offensiveChecker = null,
        string $validationMessage = 'This :attribute is not allowed.'
    ) {
        if (trim($validationMessage) === '') {
            throw new \InvalidArgumentException('The offensive validation message cannot be empty.');
        }

        if ($offensiveChecker === null) {
            $offensiveChecker = new OffensiveChecker();
        }

        $this->offensiveChecker = $offensiveChecker;
        $this->validationMessage = $validationMessage;
    }

    /**
     * Determine if the validation rule passes.
     *
     * Non-string values are left to Laravel's other validation rules. Objects
     * with __toString() are checked using their string representation.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_object($value) && method_exists($value, '__toString')) {
            $value = (string) $value;
        }

        if (!is_string($value)) {
            return true;
        }

        return !$this->offensiveChecker->isOffensive($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->validationMessage;
    }
}
