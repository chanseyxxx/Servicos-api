<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permite que qualquer usuário possa fazer a requisição, ajuste conforme necessário
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'datetime' => 'required|date_format:Y-m-d H:i:s|unique:appointments,datetime',
            'service_id' => 'required|exists:services,id',
            'phone' => 'required|string|max:20',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'datetime.unique' => 'Já existe um agendamento para esse horário. Por favor, escolha outro.',
        ];
    }

    /**
     * Customize the response when validation fails.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Verifica se há um erro de unicidade para o campo 'datetime'
        if ($errors->has('datetime')) {
            throw new HttpResponseException(response()->json([
                'error' => 'Já existe um agendamento para esse horário. Por favor, escolha outro.'
            ], 422));
        }

        // Se não for um erro de unicidade, use o comportamento padrão
        throw new HttpResponseException(response()->json($errors, 422));
    }
}
