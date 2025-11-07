<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeclarationController;
use App\Http\Controllers\LocalisationController;

Route::get('/', function () {
    $departements = \App\Models\Departement::orderBy('name')->get();
    return view('welcome', compact('departements'));
})->name('home');

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
Route::get('/find-departement', function (Request $request) {
    $name = $request->query('name');
    $departement = App\Models\Departement::where('name', 'like', '%'.$name.'%')->first();
    
    return response()->json($departement ? ['id' => $departement->id] : []);
});

Route::get('/find-commune', function (Request $request) {
    $name = $request->query('name');
    $departement = $request->query('departement');
    
    $commune = App\Models\Commune::where('name', 'like', '%'.$name.'%')
                ->whereHas('departement', function($query) use ($departement) {
                    $query->where('name', 'like', '%'.$departement.'%');
                })
                ->first();
    
    return response()->json($commune ? ['id' => $commune->id] : []);
});

Route::get('/find-arrondissement', function (Request $request) {
    $name = $request->query('name');
    $commune = $request->query('commune');
    
    $arrondissement = App\Models\Arrondissement::where('name', 'like', '%'.$name.'%')
                    ->whereHas('commune', function($query) use ($commune) {
                        $query->where('name', 'like', '%'.$commune.'%');
                    })
                    ->first();
    
    return response()->json($arrondissement ? ['id' => $arrondissement->id] : []);
});