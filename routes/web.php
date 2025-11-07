<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeclarationController;
use App\Http\Controllers\LocalisationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/declarations', [DeclarationController::class, 'create'])->name('declarations.create');
Route::post('/declarations', [DeclarationController::class, 'store'])->name('declarations.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/mes-declarations', [DeclarationController::class, 'index'])->name('declarations.index');
});

Route::get('/get-communes/{departement}', [LocalisationController::class, 'getCommunes']);
Route::get('/get-arrondissements/{commune}', [LocalisationController::class, 'getArrondissements']);

// Routes pour la recherche des IDs de localisation

// Routes améliorées pour la recherche des IDs de localisation
Route::get('/find-departement', function (Request $request) {
    $name = $request->query('name');
    
    if (!$name) {
        return response()->json([]);
    }

    // Recherche exacte d'abord
    $departement = App\Models\Departement::where('name', 'LIKE', $name)->first();
    
    // Si pas trouvé, recherche partielle
    if (!$departement) {
        $departement = App\Models\Departement::where('name', 'LIKE', "%{$name}%")->first();
    }
    
    return response()->json($departement ? [
        'id' => $departement->id,
        'name' => $departement->name,
        'match_type' => 'exact'
    ] : []);
});

Route::get('/find-commune', function (Request $request) {
    $name = $request->query('name');
    $departementId = $request->query('departement_id');
    $departementName = $request->query('departement');
    
    if (!$name) {
        return response()->json([]);
    }

    $query = App\Models\Commune::where('name', 'LIKE', $name);
    
    // Priorité à l'ID du département
    if ($departementId) {
        $query->where('departement_id', $departementId);
    } 
    // Sinon utiliser le nom du département
    elseif ($departementName) {
        $query->whereHas('departement', function($q) use ($departementName) {
            $q->where('name', 'LIKE', "%{$departementName}%");
        });
    }
    
    $commune = $query->first();
    
    // Fallback : recherche partielle sans filtre département
    if (!$commune) {
        $commune = App\Models\Commune::where('name', 'LIKE', "%{$name}%")->first();
    }
    
    return response()->json($commune ? [
        'id' => $commune->id,
        'name' => $commune->name,
        'departement_id' => $commune->departement_id
    ] : []);
});

Route::get('/mes-declarations', [DeclarationController::class, 'mesDeclarations'])
    ->name('declarations.mes-declarations')
    ->middleware('auth');

Route::get('/declarations/{id}/details', [DeclarationController::class, 'showDetails'])
    ->name('declarations.details')
    ->middleware('auth');

Route::get('/find-arrondissement', function (Request $request) {
    $name = $request->query('name');
    $communeId = $request->query('commune_id');
    $communeName = $request->query('commune');
    
    if (!$name) {
        return response()->json([]);
    }

    $query = App\Models\Arrondissement::where('name', 'LIKE', $name);
    
    // Priorité à l'ID de la commune
    if ($communeId) {
        $query->where('commune_id', $communeId);
    } 
    // Sinon utiliser le nom de la commune
    elseif ($communeName) {
        $query->whereHas('commune', function($q) use ($communeName) {
            $q->where('name', 'LIKE', "%{$communeName}%");
        });
    }
    
    $arrondissement = $query->first();
    
    // Fallback : recherche partielle sans filtre commune
    if (!$arrondissement) {
        $arrondissement = App\Models\Arrondissement::where('name', 'LIKE', "%{$name}%")->first();
    }
    
    return response()->json($arrondissement ? [
        'id' => $arrondissement->id,
        'name' => $arrondissement->name,
        'commune_id' => $arrondissement->commune_id
    ] : []);
});

// Routes de fallback pour recherches partielles
Route::get('/search-departement-partial', function (Request $request) {
    $name = $request->query('name');
    
    $departement = App\Models\Departement::where('name', 'LIKE', "%{$name}%")->first();
    
    return response()->json($departement ? ['id' => $departement->id] : []);
});

Route::get('/search-commune-partial', function (Request $request) {
    $name = $request->query('name');
    
    $commune = App\Models\Commune::where('name', 'LIKE', "%{$name}%")->first();
    
    return response()->json($commune ? ['id' => $commune->id] : []);
});

Route::get('/search-arrondissement-partial', function (Request $request) {
    $name = $request->query('name');
    
    $arrondissement = App\Models\Arrondissement::where('name', 'LIKE', "%{$name}%")->first();
    
    return response()->json($arrondissement ? ['id' => $arrondissement->id] : []);
});