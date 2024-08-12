<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permite que qualquer usuário possa fazer a requisição, ajuste conforme necessário
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'datetime' => [
                'required',
                'date_format:Y-m-d H:i:s',
                'unique:appointments,datetime,' . $this->route('id'),
            ],
            'service_id' => 'required|exists:services,id',
            'phone' => 'required|string|max:20',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        if ($errors->has('datetime')) {
            throw new HttpResponseException(response()->json([
                'error' => 'Já existe um agendamento para esse horário. Por favor, escolha outro.'
            ], 422));
        }

        throw new HttpResponseException(response()->json($errors, 422));
    }
}
