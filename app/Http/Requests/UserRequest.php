<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;

class UserRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'code'    => 500,
            'message' => 'Validation errors',
            'data'    => $validator->errors(),
        ], 500));
    }  

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
        $dt = new Carbon();
        $before = $dt->subYears(12)->format('m-d-Y');
        return [
                'email'      => 'required|string|email|unique:users',
                'first_name' => 'required|string|min:3|max:25',
                'last_name'  => 'required|string|min:3|max:25',
                'address'    => 'required|string|min:3|max:50',
                'dob'        => 'required|date|before_or_equal:' . $before,
                // 'dob'        => 'required' ,
                // 'email'      => 'required|string|email',
                'password'   => 'required|string|min:8'
        ];
    }

    public function messages()
    {
    return [
        'first_name.required'  => ['message' => 'FirstName is Required'],
        'last_name.required'   => ['message' => 'LastName is Required'],
        'address.required'     => ['message' => 'Address is Required'],
        'dob.required'         => ['message' => 'DOB is Required'],
        'dob.before_or_equal'  => ['message' => 'User must be 12+'],
        'email.required'       => ['message' => 'Email is Required'],
        'password.required'    => ['message' => 'Password is Required'],
    ];
   }
}
