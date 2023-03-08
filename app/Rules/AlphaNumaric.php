<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumaric implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        preg_match_all('!\d+!', $value, $matches);
        //return dd($matches);
        $total_number = 0;
        if(isset($matches) && count($matches) > 0) {
            foreach($matches[0] as $value) {
                //dd($value);
                $total_number += strlen($value);
            }
        }
        //dd($total_number);
        return $total_number > 4 ? false : true;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('api.set_profile_info.form_fields.username.alpha_numeric');
    }
}
