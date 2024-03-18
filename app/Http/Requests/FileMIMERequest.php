<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileMIMERequest extends FormRequest
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
            'clients' => 'required|mimes:csv,xls,xlsx|max:2048',
            'department' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'clients.required' => 'Выберите файл',
            'department.required' => 'Выберите значение или внесите новое',
            'max' => 'Размер файла не должен превышать :max Кб',
            'mimes' => 'Не допустимый тип файла или кодировка',
        ];
    }
}
