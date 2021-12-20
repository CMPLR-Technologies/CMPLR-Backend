<?php

namespace App\Http\Requests\Submit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Misc\Helpers\Errors;
use App\Http\Misc\Traits\WebServiceResponse;

class CreateSubmitRequest extends FormRequest
{

    /*
    |--------------------------------------------------------------------------
    | CreateSubmit Request
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
            'type'=>'required|string',
            'title'=>'string',
            'tags'=>'json',
            'mobile'=>'required|boolean',
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
