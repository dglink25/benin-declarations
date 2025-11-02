@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">

    {{-- En-tête --}}
    <div class="max-w-4xl mx-auto text-center mb-10 animate-fadeInSlow">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Déclarer un problème</h1>
        <p class="mt-2 text-gray-600 text-sm sm:text-base">Choisissez la forme de déclaration et remplissez les informations ci-dessous.</p>
    </div>

    {{-- Sélecteur de mode --}}
    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mb-10 animate-fadeInUp">
        <button id="btnUrgence"
            class="px-8 py-3 rounded-xl bg-red-600 text-white font-semibold shadow-lg hover:bg-red-700 hover:scale-105 active:scale-95 transition-all duration-300">
            🔴 Forme 1 : Urgence
        </button>
        <button id="btnSuivi"
            class="px-8 py-3 rounded-xl bg-green-600 text-white font-semibold shadow-lg hover:bg-green-700 hover:scale-105 active:scale-95 transition-all duration-300">
            🟢 Forme 2 : Avec suivi
        </button>
    </div>

    {{-- Conteneur principal --}}
    <div id="formContainer"
        class="max-w-3xl mx-auto bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-8 transition-all duration-500 transform hover:shadow-2xl hover:scale-[1.01]">

        {{-- Message succès --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 animate-fadeIn">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Formulaire --}}
        <form action="{{ route('declarations.store') }}" method="POST" enctype="multipart/form-data" id="declarationForm" class="space-y-6">
            @csrf
            <input type="hidden" name="urgence" id="urgence" value="0">

            {{-- Type --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Type de déclaration</label>
                <select name="type" id="type"
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 transition">
                    <option value="">-- Sélectionnez --</option>
                    <option value="incendie">Incendie</option>
                    <option value="accident">Accident</option>
                    <option value="vol">Vol</option>
                    <option value="incident_sanitaire">Incident sanitaire</option>
                    <option value="infrastructure_endommagee">Infrastructure endommagée</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            {{-- Type personnalisé --}}
            <div class="hidden" id="autreTypeContainer">
                <label class="block text-gray-700 font-semibold mb-2">Précisez le type</label>
                <input type="text" name="autre_type"
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="Ex : problème d’eau">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 transition"
                    placeholder="Décrivez le problème rencontré..." required></textarea>
            </div>

            {{-- Fichiers --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Images (max 50 Mo)</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="block w-full text-gray-700 border rounded-lg p-2 file:mr-3 file:px-3 file:py-2 file:rounded-md file:border-0 file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Vidéos (max 50 Mo)</label>
                    <input type="file" name="videos[]" multiple accept="video/*"
                        class="block w-full text-gray-700 border rounded-lg p-2 file:mr-3 file:px-3 file:py-2 file:rounded-md file:border-0 file:bg-green-600 file:text-white hover:file:bg-green-700 transition">
                </div>
            </div>

            {{-- Localisation --}}
            <h2 class="text-xl font-bold text-gray-800 mt-8 mb-3 border-b pb-1">📍 Localisation</h2>

            {{-- Choix mode localisation --}}
            <div class="flex flex-col sm:flex-row gap-4 mb-4">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="localisation_option" value="manuelle" checked class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-gray-700">Saisir manuellement</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="localisation_option" value="auto" class="text-indigo-600 focus:ring-indigo-500">
                    <span class="text-gray-700">Localisation automatique</span>
                </label>
            </div>

            {{-- Localisation manuelle --}}
            <div id="localisationManuelle" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700">Département</label>
                        <select name="departement_id" id="departement" class="w-full mt-1 rounded-lg border-gray-300">
                            <option value="">-- Sélectionnez --</option>
                            @foreach($departements as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700">Commune</label>
                        <select name="commune_id" id="commune" class="w-full mt-1 rounded-lg border-gray-300" disabled>
                            <option value="">-- Choisir un département --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700">Arrondissement</label>
                        <select name="arrondissement_id" id="arrondissement" class="w-full mt-1 rounded-lg border-gray-300" disabled>
                            <option value="">-- Choisir une commune --</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <input type="text" name="quartier" placeholder="Quartier" class="rounded-lg border-gray-300">
                    <input type="text" name="rue" placeholder="Rue" class="rounded-lg border-gray-300">
                    <input type="text" name="maison" placeholder="Maison" class="rounded-lg border-gray-300">
                </div>
            </div>

            {{-- Localisation auto --}}
            <div id="localisationAuto" class="hidden mb-4 space-y-3">
                <button type="button" id="btnGeo"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                    Activer la géolocalisation
                </button>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <div id="map" class="mt-3 w-full h-64 rounded-lg border"></div>
            </div>

            {{-- Soumission --}}
            <div class="text-center pt-4">
                <button type="submit"
                    class="px-10 py-3 bg-indigo-600 text-white rounded-xl font-semibold shadow hover:bg-indigo-700 transform hover:scale-105 transition-all duration-300">
                    Soumettre la déclaration
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts --}}
{{-- Scripts --}}
<script>
    // Animation champ "autre"
    const typeSelect = document.getElementById('type');
    const autreTypeContainer = document.getElementById('autreTypeContainer');
    typeSelect.addEventListener('change', () => {
        autreTypeContainer.classList.toggle('hidden', typeSelect.value !== 'autre');
    });

    // Boutons mode
    const btnUrgence = document.getElementById('btnUrgence');
    const btnSuivi = document.getElementById('btnSuivi');
    const urgenceInput = document.getElementById('urgence');
    btnUrgence.onclick = () => { urgenceInput.value = 1; alert("Mode urgence activé !"); };
    btnSuivi.onclick = () => { urgenceInput.value = 0; alert("Mode avec suivi activé !"); };

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
            btnGeo.textContent = "Chargement...";
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;
                initLeaflet(lat, lon);
                btnGeo.textContent = "Position détectée ✅";
            }, () => {
                alert("Impossible d’obtenir votre position.");
                btnGeo.textContent = "Réessayer";
            });
        } else {
            alert("La géolocalisation n’est pas supportée par ce navigateur.");
        }
    });

    // AJAX Départements / Communes / Arrondissements
    document.addEventListener('DOMContentLoaded', () => {
        const departementSelect = document.getElementById('departement');
        const communeSelect = document.getElementById('commune');
        const arrondissementSelect = document.getElementById('arrondissement');

        departementSelect.addEventListener('change', async function() {
            const depId = this.value;
            communeSelect.innerHTML = '<option>Chargement...</option>';
            communeSelect.disabled = true;
            arrondissementSelect.disabled = true;

            if (depId) {
                const response = await fetch(`/get-communes/${depId}`);
                const data = await response.json();
                communeSelect.innerHTML = '<option>-- Sélectionnez une commune --</option>';
                data.forEach(c => communeSelect.innerHTML += `<option value="${c.id}">${c.name}</option>`);
                communeSelect.disabled = false;
            }
        });

        communeSelect.addEventListener('change', async function() {
            const communeId = this.value;
            arrondissementSelect.innerHTML = '<option>Chargement...</option>';
            arrondissementSelect.disabled = true;

            if (communeId) {
                const response = await fetch(`/get-arrondissements/${communeId}`);
                const data = await response.json();
                arrondissementSelect.innerHTML = '<option>-- Sélectionnez un arrondissement --</option>';
                data.forEach(a => arrondissementSelect.innerHTML += `<option value="${a.id}">${a.name}</option>`);
                arrondissementSelect.disabled = false;
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
        height: 300px;
        border-radius: 12px;
        animation: fadeInMap 1s ease-in-out;
    }

    @keyframes fadeInMap {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInSlow { from { opacity: 0; } to { opacity: 1; } }
    .animate-fadeInUp { animation: fadeInUp 0.5s ease-out; }
    .animate-fadeInSlow { animation: fadeInSlow 1s ease-in; }
</style>
@endsection



