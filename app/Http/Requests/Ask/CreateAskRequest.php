<?php

namespace App\Http\Requests\Ask;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Traits\WebServiceResponse;

class CreateAskRequest extends FormRequest
{

    /*
    |--------------------------------------------------------------------------
    | CreateAsk Request
    |--------------------------------------------------------------------------|
    | This class handles the Insert Registration request : validate and filtering 
    | the request , and handle a proper error messages
    |
   */

    use WebServiceResponse;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content'=>'required',
            'layout'=>'required|json',
            'format'=>'required|string',
            'mobile'=>'required|boolean',
            'is_anonymous'=>'required|boolean'
        ];
    }

    /** 
    * 
    * this function overrides the failedValidation in validator class 
    * to return the desired failed response
    * @return json
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error_response(Errors::ERROR_MSGS_400, $validator->errors()->all(), 400)
        );
    }
}
