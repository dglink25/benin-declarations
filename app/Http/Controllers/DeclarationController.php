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
use App\Models\Commune;
use App\Models\Arrondissement;
use Illuminate\Support\Facades\DB;



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

        DB::table('declaration_user')->insert([
            'declaration_id' => $declaration->id,
            'user_id' => $validated['user_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);


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
                ->with('error', 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.' . $e->getMessage());
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
     * Valide la cohérence des données de localisation (version simplifiée)
     */
    private function validateLocationConsistency(array $localisationData): void{
        // Cette version ne bloque pas l'enregistrement en cas d'incohérence
        // Elle se contente de logger les problèmes
        
        if (!empty($localisationData['commune_id']) && !empty($localisationData['departement_id'])) {
            $commune = \App\Models\Commune::find($localisationData['commune_id']);
            if ($commune && $commune->departement_id != $localisationData['departement_id']) {
                Log::warning('Incohérence département/commune', [
                    'commune_id' => $localisationData['commune_id'],
                    'departement_soumis' => $localisationData['departement_id'],
                    'departement_reel' => $commune->departement_id
                ]);
            }
        }

        if (!empty($localisationData['arrondissement_id']) && !empty($localisationData['commune_id'])) {
            $arrondissement = \App\Models\Arrondissement::find($localisationData['arrondissement_id']);
            if ($arrondissement && $arrondissement->commune_id != $localisationData['commune_id']) {
                Log::warning('Incohérence commune/arrondissement', [
                    'arrondissement_id' => $localisationData['arrondissement_id'],
                    'commune_soumise' => $localisationData['commune_id'],
                    'commune_reelle' => $arrondissement->commune_id
                ]);
            }
        }
    }

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

    // ... vos autres méthodes existantes ...

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

            // 🔹 Analyse des descriptions pour détecter les problèmes d'infrastructure
            $declarations = $declarations->map(function ($declaration) {
                $declaration->is_occident_related = $this->analyzeOccidentRelation($declaration->description);
                $declaration->problem_type = $this->categorizeProblem($declaration->description);
                $declaration->infrastructure_type = $this->getInfrastructureType($declaration->description);
                return $declaration;
            });

            // 🔹 Récupération des déclarations d'infrastructure proches
            $nearbyInfrastructureDeclarations = $this->getNearbyInfrastructureDeclarations($user);

            // 🔹 Préparation des données pour la carte
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
                    'infrastructure_type' => $declaration->infrastructure_type,
                    'type' => 'own',
                    'user_name' => $declaration->user->name ?? 'Vous'
                ];
            });

            // 🔹 Ajout des déclarations d'infrastructure proches
            $nearbyDeclarationsMap = $nearbyInfrastructureDeclarations->map(function ($declaration) {
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
                    'problem_type' => $declaration->problem_type ?? 'autre',
                    'infrastructure_type' => $declaration->infrastructure_type ?? 'autre',
                    'user_name' => $declaration->user->name ?? 'Anonyme',
                    'type' => 'nearby'
                ];
            });

            $allDeclarationsMap = $declarationsMap->merge($nearbyDeclarationsMap);

            // 🔹 Récupération des limites géographiques du Bénin
            $beninBounds = $this->getBeninBounds();
            
            return view('declarations.mes-declarations', compact(
                'declarations', 
                'allDeclarationsMap',
                'nearbyInfrastructureDeclarations',
                'beninBounds'
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
            'infrastructure' => ['route', 'pont', 'école', 'hôpital', 'bâtiment', 'construction', 'travaux', 'panne electrique'],
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
     * Détermine le type d'infrastructure
     */
    private function getInfrastructureType($description){
        if (!$description) return 'autre';

        $description = mb_strtolower($description);
        
        $infrastructureTypes = [
            'route' => ['route', 'chemin', 'piste', 'voie', 'chaussée', 'bitume', 'asphalte', 'nid de poule'],
            'pont' => ['pont', 'passerelle', 'viaduc', 'ouvrage d\'art'],
            'école' => ['école', 'collège', 'lycée', 'université', 'salle de classe', 'établissement scolaire'],
            'hôpital' => ['hôpital', 'clinique', 'dispensaire', 'centre de santé', 'infirmerie'],
            'bâtiment' => ['bâtiment', 'immeuble', 'construction', 'édifice', 'structure'],
            'travaux' => ['travaux', 'chantier', 'construction', 'réhabilitation', 'réparation'],
            'panne électrique' => ['panne électrique', 'courant', 'électricité', 'transformateur', 'ligne électrique', 'black-out']
        ];

        foreach ($infrastructureTypes as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($description, $keyword)) {
                    return $type;
                }
            }
        }

        return 'autre';
    }

    /**
     * Récupère les déclarations d'infrastructure proches
     */
    private function getNearbyInfrastructureDeclarations($user)
    {
        try {
            // Position centrale du Bénin
            $beninLatitude = 9.3077;
            $beninLongitude = 2.3158;
            
            // Rayon de recherche en kilomètres (couvrant tout le Bénin)
            $radius = 300;

            return Declaration::with(['departement', 'commune', 'media', 'user'])
                ->where('user_id', '!=', $user->id)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->whereRaw("
                    (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                    cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
                    sin(radians(latitude)))) < ?
                ", [$beninLatitude, $beninLongitude, $beninLatitude, $radius])
                ->orderByDesc('created_at')
                ->limit(50)
                ->get()
                ->map(function ($declaration) {
                    $declaration->is_occident_related = $this->analyzeOccidentRelation($declaration->description);
                    $declaration->problem_type = $this->categorizeProblem($declaration->description);
                    $declaration->infrastructure_type = $this->getInfrastructureType($declaration->description);
                    return $declaration;
                })
                ->filter(function ($declaration) {
                    // Filtrer uniquement les problèmes d'infrastructure
                    return $declaration->problem_type === 'infrastructure';
                });

        } 
        catch (\Exception $e) {
            Log::error('Erreur récupération déclarations infrastructure proches: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Retourne les limites géographiques du Bénin
     */
    private function getBeninBounds()
    {
        // Limites géographiques du Bénin
        return [
            'north' => 12.4165,
            'south' => 6.2257,
            'east' => 3.8517,
            'west' => 0.7746,
            'center' => [9.3077, 2.3158]
        ];
    }

    /**
     * Affiche les détails d'une déclaration
     */
    public function showDetails($id)
    {
        try {
            $declaration = Declaration::with([
                'departement',
                'commune',
                'arrondissement', 
                'media',
                'user'
            ])->findOrFail($id);

            // Vérifier que l'utilisateur peut voir cette déclaration
            if ($declaration->user_id !== Auth::id()) {
                abort(403, 'Accès non autorisé à cette déclaration.');
            }

            return view('declarations.partials.details', compact('declaration'));
            
        } catch (\Exception $e) {
            Log::error('Erreur affichage détails déclaration: ' . $e->getMessage());
            return response()->json(['error' => 'Déclaration non trouvée'], 404);
        }
    }


}
