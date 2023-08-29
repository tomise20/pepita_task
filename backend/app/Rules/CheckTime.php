<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class CheckTime implements ValidationRule
{
    function __construct(private readonly string $startTime)
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startTime = Carbon::parse($this->startTime);
        $endTime = Carbon::parse($value);

        if($endTime <= $startTime) {
            $fail('A foglalás végpontjának nagyobb kell legyen mint a kezdeti');
        }
    }
}
