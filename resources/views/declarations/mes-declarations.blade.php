@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    
    {{-- En-tête --}}
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 animate-fadeIn">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-800 mb-4">
                🗺️ Carte des Infrastructures - Bénin
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Visualisation des problèmes d'infrastructure sur l'ensemble du territoire béninois
            </p>
        </div>

        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-indigo-600 mb-1">{{ $declarations->count() }}</div>
                <div class="text-sm text-gray-600 font-medium">Mes Déclarations</div>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-green-600 mb-1">
                    {{ $declarations->where('problem_type', 'infrastructure')->count() }}
                </div>
                <div class="text-sm text-gray-600 font-medium">Infrastructures</div>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-blue-600 mb-1">
                    {{ $nearbyInfrastructureDeclarations->count() }}
                </div>
                <div class="text-sm text-gray-600 font-medium">Problèmes Proches</div>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-orange-600 mb-1">
                    {{ $declarations->where('urgence', 1)->count() }}
                </div>
                <div class="text-sm text-gray-600 font-medium">Urgences</div>
            </div>
            <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-200 text-center">
                <div class="text-2xl font-bold text-purple-600 mb-1">
                    {{ $declarations->where('has_images', true)->count() }}
                </div>
                <div class="text-sm text-gray-600 font-medium">Avec Photos</div>
            </div>
        </div>

        {{-- Contrôles de la carte --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 mb-8">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex flex-wrap gap-2">
                    <button id="filter-all" class="filter-btn active px-4 py-2 bg-indigo-600 text-white rounded-xl font-medium transition-all text-sm">
                        Toutes Infrastructures
                    </button>
                    <button id="filter-own" class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-medium transition-all text-sm">
                        Mes Déclarations
                    </button>
                    <button id="filter-nearby" class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-medium transition-all text-sm">
                        Autres Déclarations
                    </button>
                    <button id="filter-urgence" class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-medium transition-all text-sm">
                        🔥 Urgences
                    </button>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <select id="infrastructure-type" class="px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-sm">
                        <option value="all">Tous types</option>
                        <option value="route">Routes</option>
                        <option value="pont">Ponts</option>
                        <option value="école">Écoles</option>
                        <option value="hôpital">Hôpitaux</option>
                        <option value="bâtiment">Bâtiments</option>
                        <option value="travaux">Travaux</option>
                        <option value="panne électrique">Pannes Électriques</option>
                    </select>
                    
                    <select id="map-style" class="px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-sm">
                        <option value="streets">Carte Standard</option>
                        <option value="satellite">Satellite</option>
                        <option value="topo">Topographique</option>
                    </select>
                    
                    <button id="locate-me" class="px-4 py-2 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition-all flex items-center gap-2 text-sm">
                        📍 Ma Position
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            
            {{-- Carte Interactive --}}
            <div class="xl:col-span-3">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-200">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Carte du Bénin - Problèmes d'Infrastructure</h2>
                            <p class="text-gray-600 text-sm mt-1">Cliquez sur les marqueurs pour voir les détails</p>
                        </div>
                        <div class="flex items-center gap-4 text-xs">
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span>Mes déclarations</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span>Autres</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span>Urgent</span>
                            </div>
                        </div>
                    </div>
                    <div id="map" class="w-full h-96 sm:h-[700px] rounded-b-2xl"></div>
                </div>
            </div>

            {{-- Panneau latéral --}}
            <div class="space-y-6">
                {{-- Légende détaillée --}}
                <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">📊 Légende des Infrastructures</h2>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 p-2 bg-blue-50 rounded-lg">
                            <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                            <span class="font-medium">Mes déclarations</span>
                        </div>
                        <div class="flex items-center gap-3 p-2 bg-green-50 rounded-lg">
                            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                            <span class="font-medium">Déclarations autres</span>
                        </div>
                        
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🛣️</span>
                                <span class="text-gray-700">Routes & Voies</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🌉</span>
                                <span class="text-gray-700">Ponts & Passerelles</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🏫</span>
                                <span class="text-gray-700">Écoles & Universités</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🏥</span>
                                <span class="text-gray-700">Hôpitaux & Cliniques</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🏗️</span>
                                <span class="text-gray-700">Bâtiments & Constructions</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🚧</span>
                                <span class="text-gray-700">Travaux & Chantiers</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-lg">💡</span>
                                <span class="text-gray-700">Pannes Électriques</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mes Déclarations --}}
                <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Mes Signalements</h2>
                    
                    @if($declarations->count() > 0)
                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($declarations as $declaration)
                                
                                <div class="declaration-card bg-gray-50 rounded-lg p-3 border-2 border-transparent hover:border-indigo-300 transition-all duration-300 hover:shadow-md cursor-pointer"
                                     data-declaration-id="{{ $declaration->id }}"
                                     data-type="own"
                                     data-infrastructure-type="{{ $declaration->infrastructure_type }}"
                                     data-urgence="{{ $declaration->urgence }}"
                                     onclick="focusOnDeclaration({{ $declaration->id }})">
                                    
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg">
                                                @switch($declaration->infrastructure_type)
                                                    @case('route') 🛣️ @break
                                                    @case('pont') 🌉 @break
                                                    @case('école') 🏫 @break
                                                    @case('hôpital') 🏥 @break
                                                    @case('bâtiment') 🏗️ @break
                                                    @case('travaux') 🚧 @break
                                                    @case('panne électrique') 💡 @break
                                                    @default 📍
                                                @endswitch
                                            </span>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-gray-500">
                                                    #{{ str_pad($declaration->id, 6, '0', STR_PAD_LEFT) }}
                                                </span>
                                                <span class="text-sm font-bold text-gray-800 capitalize">
                                                    {{ $declaration->infrastructure_type }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="text-xs text-gray-500">
                                                {{ $declaration->created_at->format('d/m') }}
                                            </span>
                                            @if($declaration->urgence)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                    🔥
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-gray-600 text-xs mb-2 line-clamp-2">
                                        {{ Str::limit($declaration->description, 80) }}
                                    </p>

                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            {{ $declaration->commune?->name ?? $declaration->departement?->name ?? 'GPS' }}
                                        </span>
                                        <button onclick="event.stopPropagation(); showDeclarationDetails({{ $declaration->id }})"
                                                class="text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                                            →
                                        </button>
                                    </div>
                                </div>
                                
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <h3 class="text-lg font-bold text-gray-700 mb-2">Aucune déclaration</h3>
                            <a href="{{ route('declarations.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-all text-sm">
                                Faire une déclaration
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Déclarations Proches --}}
                @if($nearbyInfrastructureDeclarations->count() > 0)
                    <div class="bg-white rounded-2xl shadow-2xl p-6 border border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                            Problèmes Proches
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                {{ $nearbyInfrastructureDeclarations->count() }}
                            </span>
                        </h2>
                        
                        <div class="space-y-2 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($nearbyInfrastructureDeclarations as $declaration)
                                <div class="bg-green-50 rounded-lg p-2 border border-green-200">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm">
                                                @switch($declaration->infrastructure_type)
                                                    @case('route') 🛣️ @break
                                                    @case('pont') 🌉 @break
                                                    @case('école') 🏫 @break
                                                    @case('hôpital') 🏥 @break
                                                    @default 
                                                @endswitch
                                            </span>
                                            <span class="text-xs font-medium text-gray-700 capitalize">
                                                {{ $declaration->infrastructure_type }}
                                            </span>
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            {{ $declaration->created_at->format('d/m') }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-xs mb-1 line-clamp-2">
                                        {{ Str::limit($declaration->description, 60) }}
                                    </p>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-green-700">{{ $declaration->user->name ?? 'Anonyme' }}</span>
                                        @if($declaration->urgence)
                                            <span class="text-red-600 font-bold">🔥</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal de détails --}}
<div id="declarationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
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
        width: 4px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
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
    
    .filter-btn.active {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }
    
    .infrastructure-marker {
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    
    /* Responsive pour les écrans mobiles */
    @media (max-width: 768px) {
        .grid-cols-1 {
            grid-template-columns: 1fr;
        }
        
        .xl\:col-span-3 {
            grid-column: span 1;
        }
        
        #map {
            height: 400px !important;
        }
        
        .flex-wrap {
            justify-content: center;
        }
        
        .text-4xl {
            font-size: 2rem;
        }
        
        .text-5xl {
            font-size: 2.5rem;
        }
    }
</style>

{{-- Scripts JavaScript --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>
    let map;
    let markers = [];
    let userLocationMarker = null;
    let routingControl = null;
    const declarationsData = @json($allDeclarationsMap);
    const beninBounds = @json($beninBounds);
    let currentTileLayer = null;

    // Styles de carte disponibles
    const tileLayers = {
        streets: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }),
        satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '© Esri'
        }),
        topo: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenTopoMap'
        })
    };

    // Icônes pour les types d'infrastructure
    const infrastructureIcons = {
        route: '🛣️',
        pont: '🌉',
        école: '🏫',
        hôpital: '🏥',
        bâtiment: '🏗️',
        travaux: '🚧',
        'panne electrique': '💡',
        'panne électrique': '💡',
        autre: '📍'
    };

    // Initialisation de la carte centrée sur le Bénin
    function initMap() {
        map = L.map('map', {
            minZoom: 7,
            maxBounds: [
                [beninBounds.south, beninBounds.west],
                [beninBounds.north, beninBounds.east]
            ]
        }).setView(beninBounds.center, 8);

        // Restreindre la vue au Bénin
        map.setMaxBounds([
            [beninBounds.south, beninBounds.west],
            [beninBounds.north, beninBounds.east]
        ]);

        // Appliquer le style par défaut
        changeMapStyle('streets');

        // Ajouter les marqueurs pour chaque déclaration
        declarationsData.forEach(declaration => {
            if (declaration.latitude && declaration.longitude) {
                const marker = createDeclarationMarker(declaration);
                markers.push({
                    id: declaration.id,
                    marker: marker,
                    type: declaration.type,
                    infrastructure_type: declaration.infrastructure_type,
                    urgence: declaration.urgence
                });
            }
        });

        // Appliquer le filtre par défaut (tous les marqueurs)
        filterMarkers('all', 'all');
    }

    // Créer un marqueur pour une déclaration
    function createDeclarationMarker(declaration) {
        const icon = getMarkerIcon(declaration);
        
        const marker = L.marker([declaration.latitude, declaration.longitude], { icon })
            .bindPopup(createPopupContent(declaration))
            .on('click', function() {
                showDeclarationOnSidebar(declaration.id);
            });

        return marker;
    }

    // Obtenir l'icône appropriée pour le marqueur
    function getMarkerIcon(declaration) {
        let color = declaration.type === 'own' ? 'blue' : 'green';
        if (declaration.urgence) color = 'red';

        const iconHtml = `
            <div class="infrastructure-marker" style="
                background-color: ${color};
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 14px;
                font-weight: bold;
                cursor: pointer;
            ">
                ${infrastructureIcons[declaration.infrastructure_type] || '📍'}
            </div>
        `;

        return L.divIcon({
            className: 'custom-marker',
            html: iconHtml,
            iconSize: [32, 32],
            iconAnchor: [16, 16]
        });
    }

    // Créer le contenu du popup
    function createPopupContent(declaration) {
        return `
            <div class="p-3 min-w-[250px] max-w-[300px]">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                        ${infrastructureIcons[declaration.infrastructure_type] || '📍'}
                        <span class="capitalize">${declaration.infrastructure_type}</span>
                    </h3>
                    <div class="flex gap-1">
                        ${declaration.type === 'own' ? '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">Moi</span>' : ''}
                        ${declaration.urgence ? '<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-bold">URGENT</span>' : ''}
                    </div>
                </div>
                
                <p class="text-gray-600 text-sm mb-3 leading-relaxed">${declaration.description}</p>
                
                <div class="text-xs text-gray-500 space-y-2">
                    <div class="flex justify-between">
                        <span>Localisation:</span>
                        <span class="font-medium text-gray-700">${declaration.commune || declaration.departement || 'Position GPS'}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Date:</span>
                        <span class="font-medium">${new Date(declaration.created_at).toLocaleDateString('fr-FR')}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Déclarant:</span>
                        <span class="font-medium">${declaration.user_name}</span>
                    </div>
                </div>
                
                <div class="mt-4 flex gap-2">
                    <button onclick="showDeclarationDetails(${declaration.id})" 
                            class="flex-1 bg-indigo-600 text-white py-2 px-3 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                        Voir détails
                    </button>
                    <button onclick="showRouteToDeclaration(${declaration.id})" 
                            class="flex-1 bg-green-600 text-white py-2 px-3 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                        Itinéraire
                    </button>
                </div>
            </div>
        `;
    }

    // Afficher les détails complets
    async function showDeclarationDetails(declarationId) {
        try {
            const response = await fetch(`/declarations/${declarationId}/details`);
            const html = await response.text();
            
            document.getElementById('declarationModal').innerHTML = `
                <div class="bg-white rounded-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                    ${html}
                </div>
            `;
            
            document.getElementById('declarationModal').classList.remove('hidden');
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des détails');
        }
    }

    // Afficher l'itinéraire vers la déclaration
    function showRouteToDeclaration(declarationId) {
        const declaration = declarationsData.find(d => d.id === declarationId);
        if (!declaration) return;

        // Demander la position de l'utilisateur
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    
                    // Calculer et afficher l'itinéraire
                    calculateRoute(userLat, userLng, declaration.latitude, declaration.longitude);
                },
                (error) => {
                    alert('Impossible de vous localiser pour calculer l\'itinéraire');
                }
            );
        } else {
            alert('La géolocalisation n\'est pas supportée par votre navigateur');
        }
    }

    // Calculer l'itinéraire
    function calculateRoute(fromLat, fromLng, toLat, toLng) {
        // Nettoyer l'itinéraire précédent
        if (routingControl) {
            map.removeControl(routingControl);
        }

        // Utiliser OSRM pour le calcul d'itinéraire
        routingControl = L.Routing.control({
            waypoints: [
                L.latLng(fromLat, fromLng),
                L.latLng(toLat, toLng)
            ],
            routeWhileDragging: false,
            showAlternatives: false,
            lineOptions: {
                styles: [{color: 'blue', opacity: 0.6, weight: 5}]
            }
        }).addTo(map);

        // Fermer tous les popups
        map.closePopup();
    }

    // Changer le style de la carte
    function changeMapStyle(style) {
        if (currentTileLayer) {
            map.removeLayer(currentTileLayer);
        }
        currentTileLayer = tileLayers[style];
        currentTileLayer.addTo(map);
    }

    // Filtrer les marqueurs
    function filterMarkers(filter, infrastructureType = 'all') {
        console.log('Filtrage:', filter, 'Type:', infrastructureType);
        
        markers.forEach(({ id, marker, type, infrastructure_type, urgence }) => {
            let show = false;
            
            // Filtre principal
            switch(filter) {
                case 'all':
                    show = true;
                    break;
                case 'own':
                    show = type === 'own';
                    break;
                case 'nearby':
                    show = type === 'nearby';
                    break;
                case 'urgence':
                    show = urgence;
                    break;
                default:
                    show = true;
            }
            
            // Filtre par type d'infrastructure
            if (show && infrastructureType !== 'all') {
                show = infrastructure_type === infrastructureType;
            }
            
            // Appliquer le filtre
            if (show) {
                if (!map.hasLayer(marker)) {
                    marker.addTo(map);
                }
            } else {
                if (map.hasLayer(marker)) {
                    map.removeLayer(marker);
                }
            }
        });

        // Mettre à jour les statistiques visuelles
        updateFilterStats(filter, infrastructureType);
    }

    // Mettre à jour les statistiques de filtre
    function updateFilterStats(filter, infrastructureType) {
        const filteredMarkers = markers.filter(({ type, infrastructure_type, urgence }) => {
            let match = true;
            
            switch(filter) {
                case 'all': break;
                case 'own': match = type === 'own'; break;
                case 'nearby': match = type === 'nearby'; break;
                case 'urgence': match = urgence; break;
            }
            
            if (match && infrastructureType !== 'all') {
                match = infrastructure_type === infrastructureType;
            }
            
            return match;
        });

        console.log(`Marqueurs visibles: ${filteredMarkers.length}/${markers.length}`);
    }

    // Focus sur une déclaration
    function focusOnDeclaration(declarationId) {
        // Mettre en évidence la carte dans la sidebar
        document.querySelectorAll('.declaration-card').forEach(card => {
            card.classList.remove('active');
        });
        
        const clickedCard = document.querySelector(`[data-declaration-id="${declarationId}"]`);
        if (clickedCard) {
            clickedCard.classList.add('active');
            clickedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        // Centrer la carte sur le marqueur
        const markerData = markers.find(m => m.id === declarationId);
        if (markerData) {
            const declaration = declarationsData.find(d => d.id === declarationId);
            if (declaration.latitude && declaration.longitude) {
                map.setView([declaration.latitude, declaration.longitude], 13);
                if (map.hasLayer(markerData.marker)) {
                    markerData.marker.openPopup();
                }
            }
        }
    }

    // Afficher dans la sidebar
    function showDeclarationOnSidebar(declarationId) {
        focusOnDeclaration(declarationId);
    }

    // Localiser l'utilisateur
    function locateUser() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    
                    // Vérifier si la position est dans les limites du Bénin
                    if (latitude >= beninBounds.south && latitude <= beninBounds.north &&
                        longitude >= beninBounds.west && longitude <= beninBounds.east) {
                        
                        map.setView([latitude, longitude], 13);
                        
                        // Mettre à jour ou créer le marqueur de position
                        if (userLocationMarker) {
                            userLocationMarker.setLatLng([latitude, longitude]);
                        } else {
                            userLocationMarker = L.marker([latitude, longitude], {
                                icon: L.divIcon({
                                    className: 'user-location-marker',
                                    html: '<div style="background-color: #10b981; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"></div>',
                                    iconSize: [20, 20],
                                    iconAnchor: [10, 10]
                                })
                            })
                            .addTo(map)
                            .bindPopup('<div class="p-2"><strong>Votre position actuelle</strong></div>')
                            .openPopup();
                        }
                    } else {
                        alert('Vous semblez être en dehors du Bénin. Centrage sur le Bénin.');
                        map.setView(beninBounds.center, 8);
                    }
                },
                (error) => {
                    alert('Impossible de vous localiser. Centrage sur le Bénin.');
                    map.setView(beninBounds.center, 8);
                }
            );
        } else {
            alert('La géolocalisation n\'est pas supportée par votre navigateur.');
        }
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        
        // Gestion des filtres
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => {
                    b.classList.remove('active');
                    b.classList.add('bg-gray-200', 'text-gray-700');
                    b.classList.remove('bg-indigo-600', 'text-white');
                });
                
                this.classList.add('active', 'bg-indigo-600', 'text-white');
                this.classList.remove('bg-gray-200', 'text-gray-700');
                
                const infrastructureType = document.getElementById('infrastructure-type').value;
                filterMarkers(this.id.replace('filter-', ''), infrastructureType);
            });
        });
        
        // Gestion du type d'infrastructure
        document.getElementById('infrastructure-type').addEventListener('change', function() {
            const activeFilter = document.querySelector('.filter-btn.active');
            if (activeFilter) {
                filterMarkers(activeFilter.id.replace('filter-', ''), this.value);
            } else {
                filterMarkers('all', this.value);
            }
        });
        
        // Gestion du style de carte
        document.getElementById('map-style').addEventListener('change', function() {
            changeMapStyle(this.value);
        });
        
        // Localisation
        document.getElementById('locate-me').addEventListener('click', locateUser);

        // Fermer la modal
        document.getElementById('declarationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        // Redimensionnement responsive de la carte
        window.addEventListener('resize', function() {
            setTimeout(() => {
                map.invalidateSize();
            }, 100);
        });
    });

    // Fonction pour fermer la modal
    function closeModal() {
        document.getElementById('declarationModal').classList.add('hidden');
    }
</script>

<!-- Inclure Leaflet Routing Machine -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
@endsection