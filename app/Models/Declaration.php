<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'type', 
        'description', 
        'autre_type', 
        'urgence',
        'departement_id', 
        'commune_id', 
        'arrondissement_id', 
        'quartier', 
        'rue', 
        'maison',
        'latitude', 
        'longitude', 
        'statut',
        'lien_localisation'
    ];

    public function medias(){
        return $this->hasMany(Media::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔗 Relation avec l'utilisateur
     */

    /**
     * 🔗 Relation avec le département
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    /**
     * 🔗 Relation avec la commune
     */
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    /**
     * 🔗 Relation avec l’arrondissement
     */
    public function arrondissement()
    {
        return $this->belongsTo(Arrondissement::class, 'arrondissement_id');
    }

    // 🔹 Relation avec les médias
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * 🔗 Relation avec les médias (images/vidéos)
     */
    
}
