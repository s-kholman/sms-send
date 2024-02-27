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
            'mailing_frequency' => 'required|numeric',
            'mailing_send_time' => 'date_format:H:i',
            'mailing_to_day' => 'required|numeric',
        ];
    }
}
