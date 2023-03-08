<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App;

class StrMaxNumber implements Rule
{
    private $num;
    private $error_msg;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($num,$error_msg='')
    {
        $this->num=$num;
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
        $res=preg_match_all('/\d/',$value);
        // dd($res);
      return($res<=4);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->error_msg){
            return $this->error_msg;
        }
        if(App::getLocale()=='en')
        {
            return "Maximum {$this->num} numbers are allowed.";
        }
        else
        {
            return "مسموح بحد أقصى {$this->num} أرقام";
        }        
    }
}
