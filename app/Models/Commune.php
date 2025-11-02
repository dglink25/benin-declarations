<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'id_departement', 'id_maire'];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement');
    }

    public function maire()
    {
        return $this->belongsTo(User::class, 'id_maire');
    }

    public function arrondissements()
    {
        return $this->hasMany(Arrondissement::class, 'id_commune');
    }

    public function quartiers()
    {
        return $this->hasMany(Quartier::class, 'id_commune');
    }
}
