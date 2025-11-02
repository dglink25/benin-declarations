<?php

namespace App\Http\Controllers;

use App\Models\Declaration;
use App\Models\Media;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DeclarationController extends Controller
{
    /**
     * Affiche le formulaire de création d'une déclaration.
     */
    public function create(){
        $departements = Departement::orderBy('name')->get();

        return view('declarations.create', compact('departements'));
    }

    /**
     * Enregistre une nouvelle déclaration (urgence ou avec suivi).
     */
    public function store(Request $request){
        try {
            $validated = $request->validate([
                'type' => 'required|string|max:255',
                'description' => 'required|string|max:5000',
                'autre_type' => 'nullable|string|max:255',
                'urgence' => 'nullable|boolean',

                'departement_id' => 'nullable|exists:departements,id',
                'commune_id' => 'nullable|exists:communes,id',
                'arrondissement_id' => 'nullable|exists:arrondissements,id',

                'quartier' => 'nullable|string|max:255',
                'rue' => 'nullable|string|max:255',
                'maison' => 'nullable|string|max:255',

                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',

                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:51200', // 50 Mo
                'videos.*' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:51200',
            ]);

            // Associer à l'utilisateur connecté si présent
            if (Auth::check()) {
                $validated['user_id'] = Auth::id();
            }

            $declaration = Declaration::create($validated);

            // 📸 Upload des fichiers médias
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('uploads/images', 'public');
                    Media::create([
                        'declaration_id' => $declaration->id,
                        'type' => 'image',
                        'path' => $path,
                    ]);
                }
            }

            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    $path = $video->store('uploads/videos', 'public');
                    Media::create([
                        'declaration_id' => $declaration->id,
                        'type' => 'video',
                        'path' => $path,
                    ]);
                }
            }

            return redirect()
                ->route('declarations.create')
                ->with('success', 'Déclaration envoyée avec succès ! Merci pour votre signalement.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erreurs de validation, veuillez vérifier les champs.');

        } catch (\Throwable $e) {
            Log::error('Erreur lors de la création d’une déclaration : ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l’envoi. Veuillez réessayer plus tard.');
        }
    }

    /**
     * Affiche la liste des déclarations de l'utilisateur connecté.
     */
    public function index(){
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter pour voir vos déclarations.');
        }

        // On charge toutes les relations associées
        $declarations = Declaration::with([
            'user:id,name,email',
            'departement:id,name',
            'commune:id,name,id_departement',
            'arrondissement:id,name,id_commune',
            'medias'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('declarations.index', compact('declarations'));
    }

}
