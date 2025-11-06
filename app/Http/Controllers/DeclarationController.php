<?php

namespace App\Http\Controllers;

use App\Models\Declaration;
use App\Models\Media;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class DeclarationController extends Controller{
    /**
     * Affiche le formulaire de création d'une déclaration.
     */
    public function create(){
        $departements = Departement::orderBy('name')->get();

        return view('declarations.create', compact('departements'));
    }

    public function store(Request $request){
        try {
            $validated = $request->validate([
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

                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:51200',
                'videos.*' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:51200',

                // Champs citoyens non connectés (Forme 1)
                'nom' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
            ]);

            /**
             * 🔹 Étape 1 : Identifier l’utilisateur
             */
            if (Auth::check()) {
                // Utilisateur connecté
                $validated['user_id'] = Auth::id();
            } 
            elseif ($request->urgence == 1) {
                // Déclaration d'urgence sans compte — on crée un utilisateur temporaire
                $user = User::create([
                    'name' => $request->nom ?? 'Citoyen Anonyme',
                    'email' => $request->email, // peut être nul
                    'password' => bcrypt(str()->random(12)), // mot de passe aléatoire
                    'role' => 'citoyen',
                ]);

                $validated['user_id'] = $user->id;
            } 
            elseif ($request->urgence == 0) {
                // ❌ Cas non autorisé : déclaration avec suivi sans authentification
                return back()
                    ->withInput()
                    ->with('error', 'Vous devez être connecté pour soumettre une déclaration avec suivi.');
            }


            /**
             * 🔹 Étape 2 : Création de la déclaration
             */
            $declaration = Declaration::create($validated);

            /**
             * 🔹 Étape 3 : Gestion des médias
             */
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

            /**
             * 🔹 Étape 4 : Retour utilisateur
             */
            return redirect()
                ->route('declarations.create')
                ->with('success', 'Déclaration envoyée avec succès ! Merci pour votre signalement.');

        } 
        catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Erreurs de validation, veuillez vérifier les champs.');
        } 
        catch (\Throwable $e) {
            Log::error('Erreur lors de la création d’une déclaration : ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l’envoi. Veuillez réessayer plus tard.');
        }
    }


    /**
     * Enregistre une nouvelle déclaration (urgence ou avec suivi).
     */
   

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
