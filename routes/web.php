<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeclarationController;

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

use App\Http\Controllers\LocalisationController;

Route::get('/get-communes/{departement}', [LocalisationController::class, 'getCommunes']);
Route::get('/get-arrondissements/{commune}', [LocalisationController::class, 'getArrondissements']);

