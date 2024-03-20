<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSearchRequest extends FormRequest
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
            'search' => 'nullable|max:100',
            'page' => 'int'
        ];
    }

    public function messages()
    {
        return
            [
                'required' => 'Поле обязательно для заполнение',
                'max' => 'Запрос не должен превышать :max символов',
            ];
    }
}
