<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'national_id' =>['unique:users','max:10','min:10'],
            'role'=>['required'],
            'name' => [ 'string', 'max:255', 'min:3'],
            'phone'=>['unique:users','min:10','max:10'],
            'email' => ['unique:users','email'],
            'password' => ['string','min:8','max:255','confirmed'],

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
            'phone.unique' => 'رقم الجوال مسجل بالفعل',

            'email.unique' => 'هذا البريد الألكنرونى مسجل بالفعل',

            'password.min'=>'الرقم السري يجب أن يكون أكثر من 8 أحرف',
            'password.max'=>'الرقم السري يجب أن لا يكون أكثر من 255 أحرف',
            'password.confirmed'=>' تأكيد الرقم السرى غير مطابق ',

        ];
    }
}
