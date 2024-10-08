<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Define os atributos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'type',
        'price',
        'duration',
    ];

    /**
     * Define a relação com o modelo Appointment.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'service_id');
    }
}
