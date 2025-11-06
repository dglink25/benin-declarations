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

        {{-- Message succès --}}
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-5 mb-8 rounded-xl animate-fadeIn">
                <p class="font-medium">Succès :</p>
                <p class="mt-2 text-sm">{{ session('success') }}</p>
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
                            <select name="departement_id" id="departement" required class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4">
                                <option value="">-- Sélectionnez --</option>
                                @foreach($departements as $dep)
                                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Commune --}}
                        <div class="space-y-3">
                            <label for="commune" class="block text-base font-semibold text-gray-700">Commune <span class="text-red-500">*</span></label>
                            <select name="commune_id" id="commune" required class="w-full rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 p-4" disabled>
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
                    </div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <div class="space-y-3">
                        <div id="map" class="w-full h-80 rounded-2xl shadow-lg border-2 border-gray-300 transition-all duration-500 ease-in-out"></div>
                    </div>
                </div>
            </div>

            {{-- Soumission --}}
            <div class="text-center pt-8">
                <button type="submit"
                    class="w-full sm:w-auto px-14 py-5 bg-indigo-600 text-white rounded-xl text-lg font-bold shadow-xl hover:bg-indigo-700 transform hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                    Soumettre la Déclaration
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
<script>
    // Initialisation du mode Urgence (Forme 2 par défaut)
    document.addEventListener('DOMContentLoaded', () => {
        const btnUrgence = document.getElementById('btnUrgence');
        const btnSuivi = document.getElementById('btnSuivi');
        const urgenceInput = document.getElementById('urgence');
        const allModeBtns = document.querySelectorAll('.mode-btn');

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
                // Vérifier si on est sur mobile et si la caméra est disponible
                if (/Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent)) {
                    e.preventDefault();
                    
                    // Vérifier si l'API MediaDevices est disponible
                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        // Demander à l'utilisateur ce qu'il préfère
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
                    facingMode: 'environment', // Caméra arrière
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
            // Créer la modal
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
            
            // Capturer la photo
            captureBtn.addEventListener('click', function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0);
                
                // Convertir en blob et ajouter au input file
                canvas.toBlob(function(blob) {
                    const file = new File([blob], `photo_${Date.now()}.jpg`, { type: 'image/jpeg' });
                    addFileToInput(file);
                    
                    // Fermer la modal et arrêter la caméra
                    stream.getTracks().forEach(track => track.stop());
                    modal.remove();
                }, 'image/jpeg', 0.8);
            });
            
            // Annuler
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
            
            // Créer un nouveau DataTransfer pour gérer les fichiers
            const dataTransfer = new DataTransfer();
            
            // Ajouter les fichiers existants
            for (let i = 0; i < input.files.length; i++) {
                dataTransfer.items.add(input.files[i]);
            }
            
            // Ajouter le nouveau fichier
            dataTransfer.items.add(file);
            
            // Mettre à jour les fichiers du input
            input.files = dataTransfer.files;
            
            // Déclencher un événement change pour mettre à jour l'interface
            input.dispatchEvent(new Event('change', { bubbles: true }));
            
            // Afficher un message de confirmation
            alert("Photo ajoutée avec succès !");
        };

        // Initialiser la configuration des images
        setupImageInput();

        // Animation champ "autre"
        const typeSelect = document.getElementById('type');
        const autreTypeContainer = document.getElementById('autreTypeContainer');
        if (typeSelect) {
            typeSelect.addEventListener('change', () => {
                autreTypeContainer.classList.toggle('hidden', typeSelect.value !== 'autre');
            });
        }

        // Localisation manuelle/auto
        const localisationRadios = document.getElementsByName('localisation_option');
        const locManuelle = document.getElementById('localisationManuelle');
        const locAuto = document.getElementById('localisationAuto');
        const btnGeo = document.getElementById('btnGeo');
        localisationRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                locAuto.classList.toggle('hidden', radio.value !== 'auto' || !radio.checked);
                locManuelle.classList.toggle('hidden', radio.value === 'auto' && radio.checked);
            });
        });

        // Fonction d'initialisation Leaflet
        let map, marker;
        function initLeaflet(lat, lon) {
            if (!map) {
                map = L.map('map').setView([lat, lon], 15);

                // Couche de carte OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Marqueur
                marker = L.marker([lat, lon], { draggable: true })
                    .addTo(map)
                    .bindPopup('Votre position actuelle')
                    .openPopup();

                // Quand le marqueur est déplacé, met à jour les coordonnées cachées
                marker.on('moveend', e => {
                    const { lat, lng } = e.target.getLatLng();
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                });
            } else {
                map.setView([lat, lon], 15);
                marker.setLatLng([lat, lon]);
            }
        }

        // Bouton de géolocalisation
        btnGeo.addEventListener('click', () => {
            if (navigator.geolocation) {
                btnGeo.textContent = "Recherche de la position...";
                navigator.geolocation.getCurrentPosition(pos => {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;
                    initLeaflet(lat, lon);
                    btnGeo.textContent = "Position détectée (Glisser le marqueur si besoin)";
                }, () => {
                    alert("Impossible d'obtenir votre position. Veuillez vérifier les permissions.");
                    btnGeo.textContent = "Réessayer la géolocalisation";
                });
            } else {
                alert("La géolocalisation n'est pas supportée par ce navigateur.");
            }
        });

        // AJAX Départements / Communes / Arrondissements
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
        });
    });
</script>

{{-- 🔹 Import de Leaflet (CSS + JS) --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- 🔹 Style carte et animations --}}
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
</style>
@endsection