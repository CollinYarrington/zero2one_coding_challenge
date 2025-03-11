<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxWatchlistRule implements ValidationRule
{

    protected $user, $maxRecords;

    public function __construct($user, $maxRecords = 15)
    {
        $this->user = $user;
        $this->maxRecords = $maxRecords;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->user->watchlist->count() >= $this->maxRecords) {
            $fail("You have reached the maximum limit of {$this->maxRecords} movies in your watchlist");
        }
    }
}
