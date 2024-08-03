<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // Atributos que são atribuíveis em massa
    protected $fillable = [
        'name',
        'type',
        'price',
        'duration',
    ];

    // Adicione qualquer relacionamento ou método adicional se necessário
}
