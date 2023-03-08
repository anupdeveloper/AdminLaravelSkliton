<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64FileType implements Rule
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

        $ext=substr($value,strpos($value,":")+1,strpos($value,";")-strpos($value,":")-1);
        return in_array($ext,['image/jpeg','image/png']) ;

        // $image = base64_decode($value);
        // $f = finfo_open();
        // $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
        // return in_array($result,['image/jpeg','image/png']) ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute type is invalid.';
    }
}
