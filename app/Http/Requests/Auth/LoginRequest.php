<?php

namespace App\Http\Requests\Auth;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{

    use SanitizesInput;
    


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
            'email' => ['trim','lowercase'],
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
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
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
        throw new HttpResponseException(response()->json([
            'meta'=>[
                'status'=>422,
                'msg' => '',
            ],
            'error' => $validator->errors()->all(),
        ], 422));
        
    }


}
