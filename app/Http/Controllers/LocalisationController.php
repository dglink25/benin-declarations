<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Arrondissement;

class LocalisationController extends Controller
{
    public function getCommunes($departementId){
        $communes = Commune::where('id_departement', $departementId)->get(['id', 'name']);
        return response()->json($communes);
    }

    public function getArrondissements($communeId){
        $arrondissements = Arrondissement::where('id_commune', $communeId)->get(['id', 'name']);
        return response()->json($arrondissements);
    }
}
