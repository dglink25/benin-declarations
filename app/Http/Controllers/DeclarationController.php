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
use Illuminate\Support\Str;



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
            'lien_localisation' => 'nullable|string|max:500',

            // Champs de géolocalisation automatique
            'detected_departement_id' => 'nullable|exists:departements,id',
            'detected_commune_id' => 'nullable|exists:communes,id',
            'detected_arrondissement_id' => 'nullable|exists:arrondissements,id',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:51200',
            'videos.*' => 'nullable|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:51200',

            // Champs citoyens non connectés (Forme 1)
            'user_nom' => 'nullable|string|max:255',
            'user_email' => 'nullable|email|max:255',
            'user_telephone' => 'nullable|string|max:20',
            'user_adresse' => 'nullable|string|max:500',
        ]);

        /**
         * 🔹 Étape 1 : Identifier l'utilisateur
         */
        if (Auth::check()) {
            // Utilisateur connecté
            $validated['user_id'] = Auth::id();
        } 
        elseif ($request->urgence == 1) {
            // Déclaration d'urgence sans compte — on crée un utilisateur temporaire
            $user = User::create([
                'name' => $request->user_nom ?? 'Citoyen Anonyme',
                'email' => $request->user_email, // peut être nul
                'password' => bcrypt(str()->random(12)), // mot de passe aléatoire
                'role' => 'citoyen',
            ]);

            $validated['user_id'] = $user->id;
        } 
        elseif ($request->urgence == 0) {
            // Cas non autorisé : déclaration avec suivi sans authentification
            return back()
                ->withInput()
                ->with('error', 'Vous devez être connecté pour soumettre une déclaration avec suivi.');
        }

        /**
         * 🔹 Étape 2 : Gestion de la localisation - Priorité aux champs détectés automatiquement
         */
        $localisationData = $this->processLocalisationData($request);
        
        // Fusionner les données de localisation avec les données validées
        $validated = array_merge($validated, $localisationData);

        /**
         * 🔹 Étape 3 : Création de la déclaration
         */
        $declaration = Declaration::create($validated);

        /**
         * 🔹 Étape 4 : Gestion des médias
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
         * 🔹 Étape 5 : Retour utilisateur
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
            Log::error('Erreur lors de la création d\'une déclaration : ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.');
        }
    }

    /**
     * Traite les données de localisation avec priorité aux données détectées automatiquement
     */
    private function processLocalisationData(Request $request): array{
        $localisationData = [];

        // Vérifier si on utilise la géolocalisation automatique
        $usingAutoLocation = $request->filled(['latitude', 'longitude']) && 
                            $request->filled('detected_departement_id');

        if ($usingAutoLocation) {
            // 🔹 PRIORITÉ aux données détectées automatiquement
            
            $localisationData['departement_id'] = $request->detected_departement_id;
            $localisationData['commune_id'] = $request->detected_commune_id;
            $localisationData['arrondissement_id'] = $request->detected_arrondissement_id;
            
            // Enregistrer les coordonnées GPS
            $localisationData['latitude'] = $request->latitude;
            $localisationData['longitude'] = $request->longitude;
            $localisationData['lien_localisation'] = $request->lien_localisation;

            // Log pour débogage
            Log::info('Utilisation de la géolocalisation automatique', [
                'departement_id' => $request->detected_departement_id,
                'commune_id' => $request->detected_commune_id,
                'arrondissement_id' => $request->detected_arrondissement_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

        } 
        elseif ($request->filled('departement_id')) {
            // 🔹 Utilisation des données manuelles
            $localisationData['departement_id'] = $request->departement_id;
            $localisationData['commune_id'] = $request->commune_id;
            $localisationData['arrondissement_id'] = $request->arrondissement_id;
            $localisationData['quartier'] = $request->quartier;
            $localisationData['rue'] = $request->rue;
            $localisationData['maison'] = $request->maison;

            // Log pour débogage
            Log::info('Utilisation de la localisation manuelle', [
                'departement_id' => $request->departement_id,
                'commune_id' => $request->commune_id,
                'arrondissement_id' => $request->arrondissement_id,
            ]);
        }

        // Vérification de cohérence des données
        $this->validateLocationConsistency($localisationData);

        return $localisationData;
    }

    /**
     * Valide la cohérence des données de localisation
     */
    private function validateLocationConsistency(array $localisationData): void{
        // Vérifier que si une commune est spécifiée, elle appartient bien au département
        if (!empty($localisationData['commune_id']) && !empty($localisationData['departement_id'])) {
            $commune = \App\Models\Commune::find($localisationData['commune_id']);
            if ($commune && $commune->departement_id != $localisationData['departement_id']) {
                throw new \Exception('La commune sélectionnée n\'appartient pas au département spécifié.');
            }
        }

        // Vérifier que si un arrondissement est spécifié, il appartient bien à la commune
        if (!empty($localisationData['arrondissement_id']) && !empty($localisationData['commune_id'])) {
            $arrondissement = \App\Models\Arrondissement::find($localisationData['arrondissement_id']);
            if ($arrondissement && $arrondissement->commune_id != $localisationData['commune_id']) {
                throw new \Exception('L\'arrondissement sélectionné n\'appartient pas à la commune spécifiée.');
            }
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

            
            public function mesDeclarations()
        {
            try {
                $user = Auth::user();

                if (!$user) {
                    return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à vos déclarations.');
                }

                // 🔹 Récupération des déclarations avec relations
                $declarations = Declaration::with([
                        'departement',
                        'commune',
                        'arrondissement',
                        'media',
                        'user'
                    ])
                    ->where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->get();

                // 🔹 Analyse des descriptions pour détecter les problèmes liés à l'occident
                $declarations = $declarations->map(function ($declaration) {
                    $declaration->is_occident_related = $this->analyzeOccidentRelation($declaration->description);
                    $declaration->problem_type = $this->categorizeProblem($declaration->description);
                    return $declaration;
                });

                // 🔹 Récupération des déclarations proches (dans un rayon de 50km)
                $nearbyDeclarations = $this->getNearbyDeclarations($user);

                // 🔹 Préparation des données pour affichage sur la carte
                $declarationsMap = $declarations->map(function ($declaration) {
                    return [
                        'id' => $declaration->id,
                        'latitude' => $declaration->latitude,
                        'longitude' => $declaration->longitude,
                        'description' => Str::limit($declaration->description ?? '', 100),
                        'statut' => $declaration->statut ?? 'En attente',
                        'created_at' => optional($declaration->created_at)->format('d/m/Y H:i'),
                        'departement' => $declaration->departement?->name,
                        'commune' => $declaration->commune?->name,
                        'arrondissement' => $declaration->arrondissement?->name,
                        'urgence' => $declaration->urgence,
                        'has_images' => $declaration->media->where('type', 'image')->isNotEmpty(),
                        'has_videos' => $declaration->media->where('type', 'video')->isNotEmpty(),
                        'is_occident_related' => $declaration->is_occident_related,
                        'problem_type' => $declaration->problem_type,
                        'type' => 'own' // Pour différencier ses propres déclarations
                    ];
                });

                // 🔹 Ajout des déclarations proches à la carte
                $nearbyDeclarationsMap = $nearbyDeclarations->map(function ($declaration) {
                    return [
                        'id' => $declaration->id,
                        'latitude' => $declaration->latitude,
                        'longitude' => $declaration->longitude,
                        'description' => Str::limit($declaration->description ?? '', 100),
                        'statut' => $declaration->statut ?? 'En attente',
                        'created_at' => optional($declaration->created_at)->format('d/m/Y H:i'),
                        'departement' => $declaration->departement?->name,
                        'commune' => $declaration->commune?->name,
                        'urgence' => $declaration->urgence,
                        'has_images' => $declaration->media->where('type', 'image')->isNotEmpty(),
                        'is_occident_related' => $declaration->is_occident_related ?? false,
                        'problem_type' => $declaration->problem_type ?? 'autre',
                        'user_name' => $declaration->user->name ?? 'Anonyme',
                        'type' => 'nearby' // Pour les déclarations proches
                    ];
                });

                $allDeclarationsMap = $declarationsMap->merge($nearbyDeclarationsMap);

                return view('declarations.mes-declarations', compact(
                    'declarations', 
                    'allDeclarationsMap',
                    'nearbyDeclarations'
                ));
            } 
            catch (\Throwable $e) {
                Log::error('Erreur lors de la récupération des déclarations : ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                ]);

                return redirect()->back()->with('error', 'Erreur lors du chargement de vos déclarations. Veuillez réessayer.');
            }
        }

        /**
         * Analyse si la description est liée à l'occident
         */
        private function analyzeOccidentRelation($description)
        {
            if (!$description) return false;

            $occidentKeywords = [
                'occident', 'occidental', 'europée', 'européen', 'européenne', 'amérique', 'américain',
                'france', 'français', 'allemagne', 'anglais', 'espagne', 'italie', 'usa', 'états-unis',
                'canada', 'belgique', 'suisse', 'union européenne', 'ue', 'otan', 'nato', 'west', 'western',
                'colonial', 'colonisation', 'coopération', 'développement', 'aide internationale',
                'ong occidentale', 'expert étranger', 'coopérant', 'volontaire international'
            ];

            $description = mb_strtolower($description);
            
            foreach ($occidentKeywords as $keyword) {
                if (str_contains($description, $keyword)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Catégorise le type de problème
         */
        private function categorizeProblem($description)
        {
            if (!$description) return 'non spécifié';

            $description = mb_strtolower($description);
            
            $categories = [
                'infrastructure' => ['route', 'pont', 'école', 'hôpital', 'bâtiment', 'construction', 'travaux'],
                'environnement' => ['déchet', 'pollution', 'eau', 'air', 'sol', 'déforestation', 'écologie'],
                'santé' => ['maladie', 'médecin', 'médicament', 'hôpital', 'soin', 'vaccin', 'épidémie'],
                'éducation' => ['école', 'professeur', 'élève', 'cours', 'formation', 'alphabétisation'],
                'sécurité' => ['police', 'vol', 'agression', 'accident', 'incendie', 'urgence'],
                'social' => ['pauvreté', 'chômage', 'logement', 'aide', 'solidarité', 'communauté']
            ];

            foreach ($categories as $category => $keywords) {
                foreach ($keywords as $keyword) {
                    if (str_contains($description, $keyword)) {
                        return $category;
                    }
                }
            }

            return 'autre';
        }

        /**
         * Récupère les déclarations proches de l'utilisateur
         */
        private function getNearbyDeclarations($user)
        {
            try {
                // Pour cet exemple, on utilise une position par défaut
                // En production, vous utiliserez la géolocalisation de l'utilisateur
                $defaultLatitude = 8.5; // Position par défaut (Togo)
                $defaultLongitude = 1.0;
                
                // Rayon de recherche en kilomètres
                $radius = 50;

                return Declaration::with(['departement', 'commune', 'media', 'user'])
                    ->where('user_id', '!=', $user->id) // Exclure ses propres déclarations
                    ->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->whereRaw("
                        (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                        cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
                        sin(radians(latitude)))) < ?
                    ", [$defaultLatitude, $defaultLongitude, $defaultLatitude, $radius])
                    ->orderByDesc('created_at')
                    ->limit(20) // Limiter le nombre de résultats
                    ->get()
                    ->map(function ($declaration) {
                        $declaration->is_occident_related = $this->analyzeOccidentRelation($declaration->description);
                        $declaration->problem_type = $this->categorizeProblem($declaration->description);
                        return $declaration;
                    });

            } catch (\Exception $e) {
                Log::error('Erreur récupération déclarations proches: ' . $e->getMessage());
                return collect();
            }
        }

    public function showDetails($id) {
        $declaration = Declaration::with([
            'departement',
            'commune',
            'arrondissement', 
            'media',
            'user'
        ])->findOrFail($id);

        // Vérifier que l'utilisateur peut voir cette déclaration
        if ($declaration->user_id !== Auth::id()) {
            abort(403);
        }

        return view('declarations.partials.details', compact('declaration'));
    }

}
