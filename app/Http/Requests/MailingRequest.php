<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailingRequest extends FormRequest
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
            'mailing_name' => 'required|max:255',
            'mailing_text' => 'required|max:255',
            'mailing_type' => 'required|numeric',
            'mailing_send_birth' => 'nullable|date_format:H:i',//Рассылка день рождения
            'mailing_immediate_dispatch' => 'nullable|date',//Немедленная отправка
            'mailing_deferred' => 'nullable|date',//Отправка в определенную дату
            'mailing_frequency_date' => 'nullable|date',//Дата переодичных рассылок
            'mailing_frequency_type' => 'nullable|numeric',//Повтор переодичных рассылок
            'mailing_to_day' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return
            [
                'required' => 'Поле обязательно для заполнение',
                'max' => 'Значение не должно быть длинне :max символов'
            ];
    }
}

