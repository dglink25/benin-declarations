<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_prefect'];

    public function prefect()
    {
        return $this->belongsTo(User::class, 'id_prefect');
    }

    public function communes()
    {
        return $this->hasMany(Commune::class, 'id_departement');
    }

    public function arrondissements()
    {
        return $this->hasMany(Arrondissement::class, 'id_departement');
    }

    public function quartiers()
    {
        return $this->hasMany(Quartier::class, 'id_departement');
    }
}
