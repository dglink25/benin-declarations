@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- En-tête --}}
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 animate-fadeIn">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-800 mb-4">
                Mes Déclarations
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Retrouvez l'ensemble de vos signalements avec leur statut et localisation
            </p>
            <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center items-center">
                <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-700">Traité</span>
                </div>
                <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-700">En cours</span>
                </div>
                <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-700">Urgent</span>
                </div>
            </div>
        </div>

        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 text-center">
                <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $declarations->count() }}</div>
                <div class="text-gray-600 font-medium">Total</div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">
                    {{ $declarations->where('statut', 'traité')->count() }}
                </div>
                <div class="text-gray-600 font-medium">Traités</div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 text-center">
                <div class="text-3xl font-bold text-yellow-600 mb-2">
                    {{ $declarations->where('statut', 'en_cours')->count() }}
                </div>
                <div class="text-gray-600 font-medium">En cours</div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 text-center">
                <div class="text-3xl font-bold text-red-600 mb-2">
                    {{ $declarations->where('urgence', 1)->count() }}
                </div>
                <div class="text-gray-600 font-medium">Urgences</div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            {{-- Carte Interactive --}}
            <div class="xl:col-span-2">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                            <span class="text-indigo-600">🗺️</span>
                            Carte Interactive
                        </h2>
                        <p class="text-gray-600 mt-2">Visualisez la localisation de tous vos signalements</p>
                    </div>
                    <div id="map" class="w-full h-96 sm:h-[500px] rounded-b-2xl"></div>
                </div>
            </div>

            {{-- Liste des Déclarations --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                        <span class="text-indigo-600">📋</span>
                        Liste des Signalements
                    </h2>
                    
                    @if($declarations->count() > 0)
                        <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($declarations as $declaration)
                                <div class="declaration-card bg-gray-50 rounded-xl p-4 border-2 border-transparent hover:border-indigo-300 transition-all duration-300 hover:shadow-md cursor-pointer"
                                     data-declaration-id="{{ $declaration->id }}"
                                     onclick="focusOnDeclaration({{ $declaration->id }})">
                                    
                                    {{-- En-tête de la carte --}}
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-gray-500">
                                                    #{{ str_pad($declaration->id, 6, '0', STR_PAD_LEFT) }}
                                                </span>
                                                <span class="text-lg font-bold text-gray-800">
                                                    {{ $declaration->departement?->name ?? 'Non spécifié' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="text-xs text-gray-500">
                                                {{ $declaration->created_at->format('d/m/Y') }}
                                            </span>
                                            <div class="flex items-center gap-2">
                                                @if($declaration->urgence)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                        🔥 Urgent
                                                    </span>
                                                @endif
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold 
                                                    @if($declaration->statut == 'traité') bg-green-100 text-green-800
                                                    @elseif($declaration->statut == 'en_cours') bg-yellow-100 text-yellow-800
                                                    @else bg-blue-100 text-blue-800 @endif">
                                                    {{ $declaration->statut ?? 'Nouveau' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ Str::limit($declaration->description, 120) }}
                                    </p>

                                    {{-- Localisation --}}
                                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-3">
                                        <span>📍</span>
                                        <span>
                                            @if($declaration->commune)
                                                {{ $declaration->commune->name }}
                                                @if($declaration->arrondissement)
                                                    , {{ $declaration->arrondissement->name }}
                                                @endif
                                            @else
                                                Localisation GPS
                                            @endif
                                        </span>
                                    </div>

                                    {{-- Médias et Actions --}}
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                        <div class="flex items-center gap-3">
                                            @if($declaration->media->where('type', 'image')->count() > 0)
                                                <span class="flex items-center gap-1 text-xs text-gray-500">
                                                    📸 {{ $declaration->media->where('type', 'image')->count() }}
                                                </span>
                                            @endif
                                            @if($declaration->media->where('type', 'video')->count() > 0)
                                                <span class="flex items-center gap-1 text-xs text-gray-500">
                                                    🎥 {{ $declaration->media->where('type', 'video')->count() }}
                                                </span>
                                            @endif
                                        </div>
                                        <button onclick="event.stopPropagation(); showDeclarationDetails({{ $declaration->id }})"
                                                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors">
                                            Voir détails →
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📝</div>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune déclaration</h3>
                            <p class="text-gray-500 mb-6">Vous n'avez pas encore soumis de déclaration.</p>
                            <a href="{{ route('declarations.create') }}" 
                               class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all transform hover:scale-105">
                                Faire une déclaration
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Actions Rapides --}}
                <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Actions Rapides</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('declarations.create') }}" 
                           class="flex flex-col items-center justify-center p-4 bg-indigo-50 rounded-xl border-2 border-indigo-200 hover:border-indigo-400 transition-all group">
                            <span class="text-2xl mb-2 group-hover:scale-110 transition-transform">➕</span>
                            <span class="text-sm font-medium text-indigo-700">Nouvelle Déclaration</span>
                        </a>
                        <a href="{{ route('dashboard') }}" 
                           class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-xl border-2 border-green-200 hover:border-green-400 transition-all group">
                            <span class="text-2xl mb-2 group-hover:scale-110 transition-transform">📊</span>
                            <span class="text-sm font-medium text-green-700">Tableau de Bord</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de détails --}}
<div id="declarationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        {{-- Le contenu sera chargé via JavaScript --}}
    </div>
</div>

{{-- Styles CSS --}}
<style>
    .animate-fadeIn {
        animation: fadeIn 0.8s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .declaration-card.active {
        border-color: #4f46e5;
        background: #f8faff;
    }
</style>

{{-- Scripts JavaScript --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>
    let map;
    let markers = [];
    const declarationsData = @json($declarationsMap);

    // Initialisation de la carte
    function initMap() {
        map = L.map('map').setView([8.5, 1.0], 8); // Centre sur Togo par défaut

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Ajouter les marqueurs pour chaque déclaration
        declarationsData.forEach(declaration => {
            if (declaration.latitude && declaration.longitude) {
                const marker = L.marker([declaration.latitude, declaration.longitude])
                    .addTo(map)
                    .bindPopup(`
                        <div class="p-2 min-w-[250px]">
                            <h3 class="font-bold text-lg mb-2">Déclaration #${declaration.id}</h3>
                            <p class="text-gray-600 text-sm mb-2">${declaration.description}</p>
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>${declaration.created_at}</span>
                                <span class="font-medium ${declaration.urgence ? 'text-red-600' : 'text-green-600'}">
                                    ${declaration.urgence ? '🔥 Urgent' : 'Normal'}
                                </span>
                            </div>
                        </div>
                    `);
                
                markers.push({
                    id: declaration.id,
                    marker: marker
                });
            }
        });
    }

    // Focus sur une déclaration spécifique
    function focusOnDeclaration(declarationId) {
        // Retirer la classe active de toutes les cartes
        document.querySelectorAll('.declaration-card').forEach(card => {
            card.classList.remove('active');
        });
        
        // Ajouter la classe active à la carte cliquée
        const clickedCard = document.querySelector(`[data-declaration-id="${declarationId}"]`);
        if (clickedCard) {
            clickedCard.classList.add('active');
        }
        
        // Centrer la carte sur le marqueur
        const markerData = markers.find(m => m.id === declarationId);
        if (markerData && declarationId) {
            const declaration = declarationsData.find(d => d.id === declarationId);
            if (declaration.latitude && declaration.longitude) {
                map.setView([declaration.latitude, declaration.longitude], 15);
                markerData.marker.openPopup();
            }
        }
    }

    // Afficher les détails d'une déclaration
    async function showDeclarationDetails(declarationId) {
        try {
            const response = await fetch(`/declarations/${declarationId}/details`);
            const html = await response.text();
            
            document.getElementById('declarationModal').innerHTML = `
                <div class="bg-white rounded-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                    ${html}
                </div>
            `;
            
            document.getElementById('declarationModal').classList.remove('hidden');
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    // Fermer la modal
    function closeModal() {
        document.getElementById('declarationModal').classList.add('hidden');
    }

    // Initialiser la carte quand la page est chargée
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        
        // Fermer la modal en cliquant à l'extérieur
        document.getElementById('declarationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    });
</script>
@endsection