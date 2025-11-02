<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arrondissement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_departement', 'id_commune', 'id_ca'];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement');
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'id_commune');
    }

    public function ca()
    {
        return $this->belongsTo(User::class, 'id_ca');
    }

    public function quartiers()
    {
        return $this->hasMany(Quartier::class, 'id_arrondissement');
    }
}
