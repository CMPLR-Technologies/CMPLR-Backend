<?php

namespace App\Http\Requests\Auth;

use App\Http\Misc\Helpers\Errors;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Misc\Traits\WebServiceResponse;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class GoogleRequest extends FormRequest
{
    /*
    | this request responsible for handling json response
    | of google signup   
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
            'age' => ['required', 'integer', 'between: 18,80'],
            'token' => ['required']
        ];
    }

    /** 
     * 
     * this function overrides the failedValidation in validator class 
     *  to return the desired failed response
     * @return json
     */
    protected function failedValidation (Validator $validator)
    {
        throw new HttpResponseException(
            $this->error_response(Errors::ERROR_MSGS_422, $validator->errors(), 422)
        );
    }
}
