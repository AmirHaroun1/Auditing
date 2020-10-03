<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
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
            //
            'national_id' =>[Rule::unique('users')->ignore($this->route('employee')),'max:10','min:10'],
            'role'=>['required'],
            'name' => [ 'string', 'max:255', 'min:3'],
            'phone'=>[Rule::unique('users')->ignore($this->route('employee')),'min:10','max:10'],
            'email' => [Rule::unique('users')->ignore($this->route('employee')),'email'],

        ];
    }
    public function messages()
    {
        return [

            'national_id.min' => 'رقم الهوية يجب أن يتكون من 10 أرقام',
            'national_id.max' => 'رقم الهوية يجب أن يتكون من 10 أرقام',
            'national_id.required' => 'هذا الحقل مطلوب',
            'national_id.unique' => 'رقم الهوية مسجل بالفعل',

            'role.required' => 'هذا الحقل مطلوب',

            'name.min' => 'الأسم يجب أن يكون 3 أحرف على الأقل',
            'name.max' => 'الأسم يجب أن يكون 255 حرف على الأكثر',

            'name.string' => 'الأسم يجب يتكون من أحرف',

            'phone.max' => 'رقم الجوال يجب أن يتكون من 10 أرقام',
            'phone.min' => 'رقم الجوال يجب أن يتكون من 10 أرقام',

            'email.unique' => 'هذا البريد الألكنرونى مسجل بالفعل',

        ];
    }
}
