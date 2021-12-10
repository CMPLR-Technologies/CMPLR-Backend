<?php

namespace App\Http\Requests\Auth;

use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Traits\WebServiceResponse;
use Illuminate\validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Elegant\Sanitizer\Laravel\SanitizesInput;



class ResetPasswordRequest extends FormRequest
{

    /*
    |--------------------------------------------------------------------------
    | ResetPassword Request
    |--------------------------------------------------------------------------|
    | This class handles the ResetPassword request : validate and filtering 
    | the request , and handle a proper error messages
    |
   */
    use  WebServiceResponse;
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
            'token' => ['required'],
            'email' => ['required', 'exists:users', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)
                                                            ->mixedCase()
                                                            ->letters()
                                                            ->numbers()
                                                            ->symbols()
                                                            ->uncompromised()],
            'password_confirmation' => ['required', 'same:password']
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
