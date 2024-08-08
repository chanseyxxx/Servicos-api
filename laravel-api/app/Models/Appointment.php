<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Define os atributos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'datetime',
        'service_id',
        'phone',
    ];

    /**
     * Define a relação com o modelo Service.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
