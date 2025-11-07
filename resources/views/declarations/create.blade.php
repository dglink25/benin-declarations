@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">

    {{-- En-tête --}}
    <div class="max-w-4xl mx-auto text-center mb-12 animate-fadeInSlow">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-gray-800 tracking-tight">
            Déclarer un Problème <span class="text-indigo-600">Rapide</span>
        </h1>
        <p class="mt-4 text-gray-500 text-base sm:text-lg max-w-2xl mx-auto">
            Sélectionnez la forme de déclaration et fournissez les détails requis ci-dessous.
        </p>
    </div>

    {{-- Sélecteur de mode --}}
    <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mb-16 animate-fadeInUp">
        <button id="btnUrgence"
            class="mode-btn px-8 py-4 rounded-xl font-bold shadow-lg transition-all duration-300 transform border-2 border-transparent text-white bg-red-600 hover:bg-red-700 hover:scale-[1.03] active:scale-[0.98]"
            data-mode="1">
            Forme 1 : Urgence Immédiate
        </button>
        <button id="btnSuivi"
            class="mode-btn px-8 py-4 rounded-xl font-bold shadow-lg transition-all duration-300 transform border-2 border-indigo-500 text-indigo-600 bg-white hover:bg-indigo-50 hover:scale-[1.03] active:scale-[0.98] active-mode"
            data-mode="0">
            Forme 2 : Avec Suivi et Détails
        </button>
    </div>

    {{-- Conteneur principal --}}
    <div id="formContainer"
        class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-8 sm:p-10 lg:p-12 transition-all duration-500 transform border border-gray-200">

        {{-- Messages de succès --}}
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
                <strong>Succès :</strong> {{ session('success') }}
            </div>
        @endif

        {{-- Messages d'erreur généraux --}}
        @if (session('error'))
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                <strong>⚠ Erreur :</strong> {{ session('error') }}
            </div>
        @endif

        {{-- Erreurs de validation (Laravel) --}}
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-300 text-red-700">
                <p class="font-semibold mb-2">Veuillez corriger les erreurs suivantes :</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulaire avec espacement augmenté --}}
        <form action="{{ route('declarations.store') }}" method="POST" enctype="multipart/form-data" id="declarationForm" class="space-y-12">
            @csrf
            <input type="hidden" name="urgence" id="urgence" value="0">

            {{-- Section Informations Personnelles (Forme 1 uniquement) --}}
            <div id="userInfoSection" class="hidden space-y-8 bg-gray-50 p-8 rounded-2xl border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-700 border-b-2 border-gray-200 pb-4 mb-6 flex items-center">
                    Informations Personnelles
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nom --}}
                    <div class="space-y-3">
                        <label for="user_nom" class="block text-base font-semibold text-gray-700">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="user_nom" id="user_nom" 
                            class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4"
                            placeholder="Votre nom complet">
                    </div>
                    
                    {{-- Email --}}
                    <div class="space-y-3">
                        <label for="user_email" class="block text-base font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="user_email" id="user_email" 
                            class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4"
                            placeholder="votre@email.com">
                    </div>
                    
                    {{-- Téléphone --}}
                    <div class="space-y-3">
                        <label for="user_telephone" class="block text-base font-semibold text-gray-700">Téléphone</label>
                        <input type="tel" name="user_telephone" id="user_telephone" 
                            class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4"
                            placeholder="Votre numéro de téléphone">
                    </div>
                    
                    {{-- Adresse --}}
                    <div class="space-y-3">
                        <label for="user_adresse" class="block text-base font-semibold text-gray-700">Adresse</label>
                        <input type="text" name="user_adresse" id="user_adresse" 
                            class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4"
                            placeholder="Votre adresse complète">
                    </div>
                </div>
            </div>

            {{-- Section Détails du Problème --}}
            <div class="space-y-8 bg-gray-50 p-8 rounded-2xl border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-700 border-b-2 border-gray-200 pb-4 mb-6 flex items-center">
                    Détails de l'incident
                </h2>

                <div class="space-y-3">
                    <label for="images" class="block text-base font-semibold text-gray-700">Images (Photos)</label>
                    <input type="file" name="images[]" multiple accept="image/*" id="images"
                        class="block w-full text-gray-700 border-2 border-gray-300 rounded-xl p-4 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-base file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-600 transition-all duration-200">
                </div>

                {{-- Description --}}
                <div class="space-y-3">
                    <label for="description" class="block text-base font-semibold text-gray-700">Description complète <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" required
                        class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm p-4 border-2"
                        placeholder="Décrivez précisément ce qui s'est passé, où et quand..."></textarea>
                </div>
            </div>

            {{-- Section Pièces Jointes --}}
            <div class="space-y-8 bg-gray-50 p-8 rounded-2xl border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-700 border-b-2 border-gray-200 pb-4 mb-6 flex items-center">
                    Pièces Jointes (Optionnel)
                </h2>
                <p class="text-base text-gray-600 mb-6">Aidez-nous à mieux comprendre en ajoutant des images ou vidéos (max 50 Mo par fichier).</p>

                <div class="grid sm:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label for="videos" class="block text-base font-semibold text-gray-700">Vidéos (Clips)</label>
                        <input type="file" name="videos[]" multiple accept="video/*" id="videos"
                            class="block w-full text-gray-700 border-2 border-gray-300 rounded-xl p-4 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-base file:font-semibold file:bg-green-500 file:text-white hover:file:bg-green-600 transition-all duration-200">
                    </div>
                </div>
            </div>

            {{-- Section Localisation --}}
            <div class="space-y-8 bg-gray-50 p-8 rounded-2xl border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-700 border-b-2 border-gray-200 pb-4 mb-6 flex items-center">
                    Localisation du Problème
                </h2>

                {{-- Choix mode localisation --}}
                <div class="flex flex-col sm:flex-row gap-8 mb-6 p-4 bg-white rounded-xl border border-gray-200">
                    <label class="flex items-center space-x-4 cursor-pointer p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <input type="radio" name="localisation_option" value="manuelle" checked
                            class="h-5 w-5 text-indigo-600 focus:ring-2 focus:ring-indigo-200 border-gray-300 rounded">
                        <span class="text-gray-700 font-semibold">Saisir l'adresse complète</span>
                    </label>
                    <br>
                    <label class="flex items-center space-x-4 cursor-pointer p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <input type="radio" name="localisation_option" value="auto"
                            class="h-5 w-5 text-indigo-600 focus:ring-2 focus:ring-indigo-200 border-gray-300 rounded">
                        <span class="text-gray-700 font-semibold">Utiliser la géolocalisation automatique</span>
                    </label>
                </div>

                {{-- Localisation manuelle --}}
                <div id="localisationManuelle" class="space-y-8 transition-all duration-300 ease-in-out">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Département --}}
                        <div class="space-y-3">
                            <label for="departement" class="block text-base font-semibold text-gray-700">Département <span class="text-red-500">*</span></label>
                            <select name="departement_id" id="departement" class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4">
                                <option value="">-- Sélectionnez --</option>
                                @foreach($departements as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Commune --}}
                        <div class="space-y-3">
                            <label for="commune" class="block text-base font-semibold text-gray-700">Commune</label>
                            <select name="commune_id" id="commune" class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4" disabled>
                                <option value="">-- Choisir un département --</option>
                            </select>
                        </div>
                        {{-- Arrondissement --}}
                        <div class="space-y-3">
                            <label for="arrondissement" class="block text-base font-semibold text-gray-700">Arrondissement</label>
                            <select name="arrondissement_id" id="arrondissement" class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4" disabled>
                                <option value="">-- Choisir une commune --</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="space-y-3">
                            <input type="text" name="quartier" placeholder="Quartier / Village" 
                                class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4">
                        </div>
                        <div class="space-y-3">
                            <input type="text" name="rue" placeholder="Rue / Lieu-dit" 
                                class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4">
                        </div>
                        <div class="space-y-3">
                            <input type="text" name="maison" placeholder="Numéro Maison / Référence" 
                                class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4">
                        </div>
                    </div>
                </div>

                {{-- Localisation auto --}}
                <div id="localisationAuto" class="hidden transition-all duration-300 ease-in-out space-y-6">
                    <div class="space-y-3">
                        <button type="button" id="btnGeo"
                            class="px-8 py-4 bg-blue-600 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-700 transition-all transform hover:scale-[1.03] active:scale-[0.98] flex items-center gap-3">
                            <span>🌐</span>
                            <span>Activer la géolocalisation</span>
                        </button>
                        <p class="text-sm text-gray-500 mt-2">
                            Cliquez pour détecter automatiquement votre position. Assurez-vous d'autoriser l'accès à votre localisation.
                        </p>
                    </div>

                    {{-- État de la géolocalisation --}}
                    <div id="geoStatus" class="hidden p-4 rounded-lg bg-yellow-50 border border-yellow-200">
                        <div class="flex items-center gap-3">
                            <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-600 border-t-transparent"></div>
                            <span class="text-yellow-700 font-medium" id="geoStatusText">Détection de la position en cours...</span>
                        </div>
                    </div>
                    
                    {{-- Champs de coordonnées visibles --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label for="latitude" class="block text-base font-semibold text-gray-700">Latitude</label>
                            <input type="text" name="latitude" id="latitude"
                                class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4 bg-gray-50"
                                placeholder="Latitude GPS" readonly>
                        </div>
                        <div class="space-y-3">
                            <label for="longitude" class="block text-base font-semibold text-gray-700">Longitude</label>
                            <input type="text" name="longitude" id="longitude"
                                class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4 bg-gray-50"
                                placeholder="Longitude GPS" readonly>
                        </div>
                    </div>

                    {{-- Carte --}}
                    <div class="space-y-3">
                        <label class="block text-base font-semibold text-gray-700">Carte de localisation</label>
                        <div id="map" class="w-full h-80 rounded-2xl shadow-lg border-2 border-gray-300 transition-all duration-500 ease-in-out bg-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <div class="text-4xl mb-2">🌍</div>
                                <p>La carte s'affichera ici après activation de la géolocalisation</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500">Glissez le marqueur pour ajuster précisément votre position</p>
                    </div>

                    {{-- Lien de localisation --}}
                    <div class="space-y-3">
                        <label for="lien_localisation" class="block text-base font-semibold text-gray-700">Lien de localisation (Google Maps)</label>
                        <input type="text" name="lien_localisation" id="lien_localisation"
                            class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4 bg-gray-50"
                            placeholder="Lien Google Maps" readonly>
                    </div>

                    {{-- Informations géocodées --}}
                    <div id="geoInfo" class="hidden space-y-6 p-6 bg-blue-50 rounded-2xl border-2 border-blue-200">
                        <h3 class="text-xl font-bold text-blue-800 flex items-center gap-2">
                            Informations de localisation détectées
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Département détecté --}}
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-blue-700">Département</label>
                                <div class="flex items-center gap-3">
                                    <input type="text" id="detected_departement" 
                                        class="w-full rounded-xl border-2 border-blue-300 bg-white p-4 font-medium text-blue-800"
                                        readonly>
                                    <input type="hidden" name="detected_departement_id" id="detected_departement_id">
                                </div>
                            </div>
                            
                            {{-- Commune détectée --}}
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-blue-700">Commune</label>
                                <div class="flex items-center gap-3">
                                    <input type="text" id="detected_commune" 
                                        class="w-full rounded-xl border-2 border-blue-300 bg-white p-4 font-medium text-blue-800"
                                        readonly>
                                    <input type="hidden" name="detected_commune_id" id="detected_commune_id">
                                </div>
                            </div>
                            
                            {{-- Arrondissement détecté --}}
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-blue-700">Arrondissement</label>
                                <div class="flex items-center gap-3">
                                    <input type="text" id="detected_arrondissement" 
                                        class="w-full rounded-xl border-2 border-blue-300 bg-white p-4 font-medium text-blue-800"
                                        readonly>
                                    <input type="hidden" name="detected_arrondissement_id" id="detected_arrondissement_id">
                                </div>
                            </div>
                        </div>

                        {{-- Adresse complète --}}
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-blue-700">Adresse complète</label>
                            <input type="text" id="detected_adresse" 
                                class="w-full rounded-xl border-2 border-blue-300 bg-white p-4 font-medium text-blue-800"
                                readonly>
                        </div>

                        <div class="flex items-center gap-2 text-blue-600">
                            <span class="text-sm">Ces informations ont été automatiquement détectées à partir de votre position GPS</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Soumission --}}
            <div class="text-center pt-8">
                <button type="submit" id="submitBtn"
                    class="w-full sm:w-auto px-14 py-5 bg-indigo-600 text-white rounded-xl text-lg font-bold shadow-xl hover:bg-indigo-700 transform hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                    Soumettre la Déclaration
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Variables globales
        let map, marker;
        let currentLat, currentLon;
        let isGeolocationActive = false;

        // Initialisation du mode Urgence (Forme 2 par défaut)
        const btnUrgence = document.getElementById('btnUrgence');
        const btnSuivi = document.getElementById('btnSuivi');
        const urgenceInput = document.getElementById('urgence');
        const allModeBtns = document.querySelectorAll('.mode-btn');
        const submitBtn = document.getElementById('submitBtn');

        // Fonction pour mettre à jour l'état du bouton de soumission
        const updateSubmitButton = () => {
            const isManualLocation = document.querySelector('input[name="localisation_option"]:checked').value === 'manuelle';
            const hasManualLocation = document.getElementById('departement').value !== '';
            const hasAutoLocation = isGeolocationActive && document.getElementById('latitude').value !== '';
            
            // Pour la géolocalisation automatique, on n'exige pas de département
            const canSubmit = (isManualLocation && hasManualLocation) || (!isManualLocation && hasAutoLocation);
            
            console.log('Manual location:', isManualLocation, 'Has manual:', hasManualLocation, 'Has auto:', hasAutoLocation, 'Can submit:', canSubmit);
        };

        // Fonction pour gérer l'affichage des infos utilisateur
        const toggleUserInfoSection = (mode) => {
            const userInfoSection = document.getElementById('userInfoSection');
            const userFields = ['user_nom', 'user_email', 'user_telephone', 'user_adresse'];
            
            if (mode === 1) {
                // Forme 1 - Afficher et rendre requis
                userInfoSection.classList.remove('hidden');
                userFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (field === 'user_nom' || field === 'user_email') {
                        input.required = true;
                    }
                });
            } 
            else {
                // Forme 2 - Cacher et rendre non requis
                userInfoSection.classList.add('hidden');
                userFields.forEach(field => {
                    const input = document.getElementById(field);
                    input.required = false;
                });
            }
            updateSubmitButton();
        };

        // Fonction pour mettre à jour le style des boutons
        const updateModeStyle = (mode) => {
            allModeBtns.forEach(btn => {
                const isSelected = btn.getAttribute('data-mode') === mode.toString();
                btn.classList.remove('active-mode', 'bg-red-600', 'hover:bg-red-700', 'text-white', 'border-indigo-500', 'text-indigo-600', 'bg-white', 'hover:bg-indigo-50');

                if (isSelected && mode === 1) {
                    // Style pour Urgence
                    btn.classList.add('bg-red-600', 'hover:bg-red-700', 'text-white', 'border-transparent', 'active-mode');
                } else if (isSelected && mode === 0) {
                    // Style pour Suivi
                    btn.classList.add('border-2', 'border-indigo-500', 'text-indigo-600', 'bg-white', 'hover:bg-indigo-50', 'active-mode');
                } else if (mode === 1) {
                    // Style pour Suivi quand Urgence est actif
                    btnSuivi.classList.add('border-2', 'border-gray-300', 'text-gray-500', 'bg-white', 'hover:bg-gray-100');
                } else if (mode === 0) {
                    // Style pour Urgence quand Suivi est actif
                    btnUrgence.classList.add('border-2', 'border-gray-300', 'text-gray-500', 'bg-white', 'hover:bg-gray-100');
                }
            });
            
            // Gérer l'affichage des infos utilisateur
            toggleUserInfoSection(mode);
        };
        
        // Initialiser avec le mode Suivi (0) par défaut
        updateModeStyle(0); 

        // Gestion du clic des boutons
        btnUrgence.onclick = () => {
            urgenceInput.value = 1;
            updateModeStyle(1);
            alert("Mode Urgence Immédiate activé ! Votre déclaration sera traitée en priorité.\n\nVous devez fournir vos informations personnelles.");
        };
        btnSuivi.onclick = () => {
            urgenceInput.value = 0;
            updateModeStyle(0);
            alert("Mode Avec Suivi et Détails activé !");
        };

        // Fonction pour gérer l'input d'images avec caméra
        const setupImageInput = () => {
            const imageInput = document.getElementById('images');
            
            imageInput.addEventListener('click', function(e) {
                if (/Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent)) {
                    e.preventDefault();
                    
                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        const choice = confirm(
                            "Voulez-vous utiliser la caméra pour prendre une photo ?\n\n" +
                            "OK : Prendre une photo avec la caméra\n" +
                            "Annuler : Choisir depuis les fichiers"
                        );
                        
                        if (choice) {
                            openCamera();
                        } else {
                            openFileSelection();
                        }
                    } else {
                        openFileSelection();
                    }
                }
            });
        };

        // Fonction pour ouvrir la caméra
        const openCamera = () => {
            const constraints = {
                video: { 
                    facingMode: 'environment',
                    width: { ideal: 1920 },
                    height: { ideal: 1080 }
                },
                audio: false
            };

            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(stream) {
                    showCameraModal(stream);
                })
                .catch(function(error) {
                    console.error('Erreur caméra:', error);
                    alert("Impossible d'accéder à la caméra. Utilisation de la sélection de fichiers.");
                    openFileSelection();
                });
        };

        // Fonction pour afficher la modal de caméra
        const showCameraModal = (stream) => {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Prendre une photo</h3>
                    
                    <video id="cameraPreview" autoplay playsinline class="w-full h-64 bg-gray-200 rounded-lg mb-4"></video>
                    
                    <div class="flex justify-between gap-3">
                        <button type="button" id="captureBtn" 
                            class="flex-1 bg-green-500 text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">
                            Prendre la photo
                        </button>
                        <button type="button" id="cancelCameraBtn" 
                            class="flex-1 bg-gray-500 text-white py-3 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                            Annuler
                        </button>
                    </div>
                    
                    <canvas id="photoCanvas" class="hidden"></canvas>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            const video = modal.querySelector('#cameraPreview');
            const canvas = modal.querySelector('#photoCanvas');
            const captureBtn = modal.querySelector('#captureBtn');
            const cancelBtn = modal.querySelector('#cancelCameraBtn');
            
            video.srcObject = stream;
            
            captureBtn.addEventListener('click', function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0);
                
                canvas.toBlob(function(blob) {
                    const file = new File([blob], `photo_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    addFileToInput(file);
                    
                    stream.getTracks().forEach(track => track.stop());
                    modal.remove();
                }, 'image/jpeg', 0.8);
            });
            
            cancelBtn.addEventListener('click', function() {
                stream.getTracks().forEach(track => track.stop());
                modal.remove();
                openFileSelection();
            });
        };

        // Fonction pour ouvrir la sélection de fichiers normale
        const openFileSelection = () => {
            const input = document.getElementById('images');
            const event = new MouseEvent('click', {
                view: window,
                bubbles: true,
                cancelable: true
            });
            input.dispatchEvent(event);
        };

        // Fonction pour ajouter un fichier au input
        const addFileToInput = (file) => {
            const input = document.getElementById('images');
            const dataTransfer = new DataTransfer();
            
            for (let i = 0; i < input.files.length; i++) {
                dataTransfer.items.add(input.files[i]);
            }
            
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            input.dispatchEvent(new Event('change', { bubbles: true }));
            alert("Photo ajoutée avec succès !");
        };

        // Initialiser la configuration des images
        setupImageInput();

        // Localisation manuelle/auto
        const localisationRadios = document.getElementsByName('localisation_option');
        const locManuelle = document.getElementById('localisationManuelle');
        const locAuto = document.getElementById('localisationAuto');
        const btnGeo = document.getElementById('btnGeo');
        const geoStatus = document.getElementById('geoStatus');
        const geoStatusText = document.getElementById('geoStatusText');

        localisationRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'auto' && radio.checked) {
                    locAuto.classList.remove('hidden');
                    locManuelle.classList.add('hidden');
                    // Supprimer les attributs required des champs manuels
                    document.getElementById('departement').removeAttribute('required');
                    document.getElementById('commune').removeAttribute('required');
                } else {
                    locAuto.classList.add('hidden');
                    locManuelle.classList.remove('hidden');
                    // Remettre les required pour la localisation manuelle
                    document.getElementById('departement').setAttribute('required', 'required');
                }
                updateSubmitButton();
            });
        });

        // Fonction d'initialisation Leaflet
        function initLeaflet(lat, lon) {
            // Vider la carte d'abord
            const mapContainer = document.getElementById('map');
            mapContainer.innerHTML = '';
            
            map = L.map('map').setView([lat, lon], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Marqueur personnalisé pour plus de précision
            marker = L.marker([lat, lon], { 
                draggable: true,
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: '<div style="background-color: #3b82f6; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 10px rgba(0,0,0,0.3);"></div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                })
            })
            .addTo(map)
            .bindPopup('Votre position actuelle<br><small>Glissez le marqueur pour ajuster précisément</small>')
            .openPopup();

            marker.on('moveend', async function(e) {
                const { lat, lng } = e.target.getLatLng();
                updateCoordinates(lat, lng);
                await reverseGeocode(lat, lng);
            });

            // Ajouter un cercle de précision
            L.circle([lat, lon], {
                color: '#3b82f6',
                fillColor: '#3b82f6',
                fillOpacity: 0.1,
                radius: 20 // 20m de rayon pour indiquer la précision
            }).addTo(map);
        }

        // Fonction pour mettre à jour les coordonnées
        function updateCoordinates(lat, lng) {
            currentLat = lat;
            currentLon = lng;
            
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            document.getElementById('lien_localisation').value = `https://www.google.com/maps?q=${lat},${lng}&z=16`;
            
            isGeolocationActive = true;
            updateSubmitButton();
            
            console.log('Coordinates updated:', lat, lng, 'isGeolocationActive:', isGeolocationActive);
        }

        // FONCTION MANQUANTE : Géocodage inverse
        async function reverseGeocode(lat, lng) {
            const geoInfo = document.getElementById('geoInfo');
            
            try {
                geoStatusText.textContent = "Récupération des informations d'adresse...";
                
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                const data = await response.json();
                
                if (data && data.address) {
                    const address = data.address;
                    
                    // Récupérer les informations d'adresse avec meilleure précision
                    const departement = address.state || address.county || address.region || 'Non spécifié';
                    const commune = address.city || address.town || address.village || address.municipality || 'Non spécifié';
                    const arrondissement = address.suburb || address.city_district || address.borough || 'Non spécifié';
                    const quartier = address.neighbourhood || address.quarter || '';
                    const rue = address.road || '';
                    const numero = address.house_number || '';
                    
                    // Mettre à jour l'interface
                    document.getElementById('detected_departement').value = departement;
                    document.getElementById('detected_commune').value = commune;
                    document.getElementById('detected_arrondissement').value = arrondissement;
                    
                    let adresseComplete = '';
                    if (numero) adresseComplete += numero + ' ';
                    if (rue) adresseComplete += rue + ', ';
                    if (quartier) adresseComplete += quartier + ', ';
                    if (arrondissement !== 'Non spécifié') adresseComplete += arrondissement + ', ';
                    adresseComplete += commune + ', ' + departement;
                    
                    document.getElementById('detected_adresse').value = adresseComplete;
                    
                    // Afficher la section d'information
                    geoInfo.classList.remove('hidden');
                    
                    // Essayer de trouver les IDs correspondants dans la base de données
                    await findMatchingLocationIds(departement, commune, arrondissement);
                    
                    geoStatusText.textContent = "Position détectée avec succès !";
                    setTimeout(() => {
                        geoStatus.classList.add('hidden');
                    }, 2000);
                    
                    console.log('Reverse geocoding successful');
                }
            } catch (error) {
                console.error('Erreur géocodage:', error);
                geoStatusText.textContent = "Erreur lors de la récupération des informations de localisation.";
                setTimeout(() => {
                    geoStatus.classList.add('hidden');
                }, 3000);
            }
        }

        // Fonction pour trouver les IDs correspondants
        async function findMatchingLocationIds(departement, commune, arrondissement) {
            try {
                console.log('Recherche des IDs pour:', { departement, commune, arrondissement });

                // Recherche du département
                if (departement !== 'Non spécifié') {
                    const depResponse = await fetch(`/find-departement?name=${encodeURIComponent(departement)}`);
                    if (depResponse.ok) {
                        const depData = await depResponse.json();
                        console.log('Résultat recherche département:', depData);
                        if (depData.id) {
                            document.getElementById('detected_departement_id').value = depData.id;
                            console.log('Département ID trouvé:', depData.id);
                        } else {
                            console.log('Aucun département trouvé pour:', departement);
                        }
                    }
                }

                // Recherche de la commune
                if (commune !== 'Non spécifié') {
                    const comResponse = await fetch(`/find-commune?name=${encodeURIComponent(commune)}&departement=${encodeURIComponent(departement)}`);
                    if (comResponse.ok) {
                        const comData = await comResponse.json();
                        console.log('Résultat recherche commune:', comData);
                        if (comData.id) {
                            document.getElementById('detected_commune_id').value = comData.id;
                            console.log('Commune ID trouvé:', comData.id);
                        } else {
                            console.log('Aucune commune trouvée pour:', commune);
                        }
                    }
                }

                // Recherche de l'arrondissement
                if (arrondissement !== 'Non spécifié') {
                    const arrResponse = await fetch(`/find-arrondissement?name=${encodeURIComponent(arrondissement)}&commune=${encodeURIComponent(commune)}`);
                    if (arrResponse.ok) {
                        const arrData = await arrResponse.json();
                        console.log('Résultat recherche arrondissement:', arrData);
                        if (arrData.id) {
                            document.getElementById('detected_arrondissement_id').value = arrData.id;
                            console.log('Arrondissement ID trouvé:', arrData.id);
                        } else {
                            console.log('Aucun arrondissement trouvé pour:', arrondissement);
                        }
                    }
                }

            } catch (error) {
                console.error('Erreur recherche IDs:', error);
            }
        }

        // Bouton de géolocalisation amélioré
        btnGeo.addEventListener('click', () => {
            if (navigator.geolocation) {
                geoStatus.classList.remove('hidden');
                geoStatusText.textContent = "Détection de la position en cours...";
                btnGeo.disabled = true;
                
                navigator.geolocation.getCurrentPosition(
                    async pos => {
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        const accuracy = pos.coords.accuracy;
                        
                        geoStatusText.textContent = `Position détectée (précision: ${Math.round(accuracy)}m) - Traitement...`;
                        
                        updateCoordinates(lat, lon);
                        initLeaflet(lat, lon);
                        await reverseGeocode(lat, lon);
                        
                        btnGeo.disabled = false;
                        btnGeo.innerHTML = '<span>Position détectée</span>';
                        btnGeo.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        btnGeo.classList.add('bg-green-600', 'hover:bg-green-700');
                        
                    }, 
                    (error) => {
                        console.error('Erreur géolocalisation:', error);
                        let message = "Impossible d'obtenir votre position. ";
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                message += "Vous avez refusé l'accès à la géolocalisation. Veuillez autoriser l'accès dans les paramètres de votre navigateur.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                message += "Les informations de localisation sont indisponibles. Vérifiez votre connexion GPS.";
                                break;
                            case error.TIMEOUT:
                                message += "La demande de localisation a expiré. Veuillez réessayer.";
                                break;
                            default:
                                message += "Erreur inconnue. Veuillez réessayer.";
                        }
                        
                        geoStatusText.textContent = message;
                        setTimeout(() => {
                            geoStatus.classList.add('hidden');
                        }, 5000);
                        btnGeo.disabled = false;
                    }, 
                    {
                        enableHighAccuracy: true,
                        timeout: 15000, // 15 secondes de timeout
                        maximumAge: 60000 // Ne pas utiliser une position de plus d'1 minute
                    }
                );
            } else {
                alert("La géolocalisation n'est pas supportée par ce navigateur.");
            }
        });

        // AJAX Départements / Communes / Arrondissements (pour la localisation manuelle)
        const departementSelect = document.getElementById('departement');
        const communeSelect = document.getElementById('commune');
        const arrondissementSelect = document.getElementById('arrondissement');

        departementSelect.addEventListener('change', async function() {
            const depId = this.value;
            communeSelect.innerHTML = '<option value="">Chargement...</option>';
            communeSelect.disabled = true;
            arrondissementSelect.innerHTML = '<option value="">-- Choisir une commune --</option>';
            arrondissementSelect.disabled = true;

            if (depId) {
                const response = await fetch(`/get-communes/${depId}`);
                const data = await response.json();
                communeSelect.innerHTML = '<option value="">-- Sélectionnez une commune --</option>';
                data.forEach(c => communeSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`);
                communeSelect.disabled = false;
            } else {
                communeSelect.innerHTML = '<option value="">-- Choisir un département --</option>';
            }
            updateSubmitButton();
        });

        communeSelect.addEventListener('change', async function() {
            const communeId = this.value;
            arrondissementSelect.innerHTML = '<option value="">Chargement...</option>';
            arrondissementSelect.disabled = true;

            if (communeId) {
                const response = await fetch(`/get-arrondissements/${communeId}`);
                const data = await response.json();
                arrondissementSelect.innerHTML = '<option value="">-- Sélectionnez un arrondissement --</option>';
                data.forEach(a => arrondissementSelect.innerHTML += `<option value="${a.id}">${a.name}</option>`);
                arrondissementSelect.disabled = false;
            } else {
                arrondissementSelect.innerHTML = '<option value="">-- Choisir une commune --</option>';
            }
            updateSubmitButton();
        });

        // Écouter les changements sur les champs de localisation manuelle
        document.querySelectorAll('#localisationManuelle select, #localisationManuelle input').forEach(field => {
            field.addEventListener('change', updateSubmitButton);
        });

        // Initialiser l'état du bouton
        updateSubmitButton();
    });
</script>

{{-- Import de Leaflet --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- Styles --}}
<style>
    #map {
        width: 100%;
        height: 320px; 
        border-radius: 12px;
        animation: fadeInMap 1s ease-in-out;
    }

    /* Styles pour la modal caméra */
    .fixed {
        position: fixed;
    }
    .inset-0 {
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    .bg-opacity-75 {
        --tw-bg-opacity: 0.75;
    }
    .z-50 {
        z-index: 50;
    }

    /* Animation pour la modal */
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .fixed.inset-0 {
        animation: modalFadeIn 0.2s ease-out;
    }

    /* Animations de base */
    @keyframes fadeInMap { 
        from { opacity: 0; transform: scale(0.98); } 
        to { opacity: 1; transform: scale(1); } 
    }
    @keyframes fadeInUp { 
        from { opacity: 0; transform: translateY(20px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    @keyframes fadeInSlow { 
        from { opacity: 0; } 
        to { opacity: 1; } 
    }
    .animate-fadeInUp { animation: fadeInUp 0.5s ease-out; }
    .animate-fadeInSlow { animation: fadeInSlow 1s ease-in; }

    /* Style pour les informations géolocalisées */
    #geoInfo {
        animation: slideDown 0.5s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Style pour le marqueur personnalisé */
    .custom-marker {
        background: transparent !important;
        border: none !important;
    }
</style>
@endsection