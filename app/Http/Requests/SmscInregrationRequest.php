<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmscInregrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|max:255',
            'api_key' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return
            [
                'required' => 'Заполните это поле',
                'max' => 'Значение не должно быть длинне :max символов'
            ];
    }
}
