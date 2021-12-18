<?php

namespace App\Http\Requests\Auth;

use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Traits\WebServiceResponse;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /*
    |--------------------------------------------------------------------------
    | Register Request
    |--------------------------------------------------------------------------|
    | This class handles the Insert Registration request : validate and filtering 
    | the request , and handle a proper error messages
    |
   */
    use SanitizesInput, WebServiceResponse;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * filtering that apply to the request
     */
    public function filters()
    {
        return [
            'email' => ['trim', 'lowercase'],
            'blog_name' => ['trim', 'lowercase']
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'blog_name' => ['required', 'unique:blogs', 'max:22', 'alpha_dash'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'string', Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'age' => ['required', 'integer', 'between: 18,80']
        ];
    }




    /** 
     * 
     * this function overrides the failedValidation in validator class 
     *  to return the desired failed response
     * @return json
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error_response(Errors::ERROR_MSGS_400, $validator->errors(), 400)
        );
    }
}
