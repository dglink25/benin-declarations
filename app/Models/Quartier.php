<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'liens_google_maps',
        'id_departement',
        'id_commune',
        'id_arrondissement',
        'id_cq'
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'id_commune');
    }

    public function arrondissement()
    {
        return $this->belongsTo(Arrondissement::class, 'id_arrondissement');
    }

    public function cq()
    {
        return $this->belongsTo(User::class, 'id_cq');
    }
}
