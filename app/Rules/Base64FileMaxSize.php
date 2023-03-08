<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64FileMaxSize implements Rule
{
    private $size;


    /**
     * Create a new rule instance.
     *@param $size size in KB
     * @return void
     */
    public function __construct(int $size)
    {
        $this->size=$size;
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
        $size_in_bytes = (int) (strlen(rtrim($value, '=')) * 3 / 4);
        $size_in_kb    = $size_in_bytes / 5120;
        // $size_in_mb    = $size_in_kb / 1024;

        return $size_in_kb<=$this->size;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.max.numeric',['max'=>$this->size.' kb']);
    }
}
