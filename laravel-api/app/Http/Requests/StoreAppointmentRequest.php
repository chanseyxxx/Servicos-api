<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'datetime' => 'required|date_format:Y-m-d H:i:s|unique:appointments,datetime',
            'service_id' => 'required|exists:services,id', // Verifica se o service_id existe na tabela services
            'phone' => 'required|string|max:20',
        ];
    }

    public function authorize()
    {
        return true; // Ajuste isso conforme necessário para o controle de acesso
    }
}
