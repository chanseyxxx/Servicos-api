<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateServiceRequest extends FormRequest
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
        $serviceId = $this->route('service'); // Obtém o ID do serviço da rota

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:services,name,' . $serviceId, // Verifica a unicidade exceto o próprio serviço
            ],
            'type' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'duration' => 'sometimes|required|integer|min:1',
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

        // Verifica se há um erro de unicidade para o campo 'name'
        if ($errors->has('name')) {
            throw new HttpResponseException(response()->json([
                'error' => 'The name has already been used.'
            ], 422));
        }

        // Se não for um erro de unicidade, use o comportamento padrão
        throw new HttpResponseException(response()->json($errors, 422));
    }
}
