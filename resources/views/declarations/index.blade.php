@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">

    {{-- Titre --}}
    <div class="max-w-6xl mx-auto mb-12 text-center animate-fadeInDown">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800 tracking-tight">
            Historique de vos <span class="text-indigo-600">Déclarations</span>
        </h1>
        <p class="text-gray-500 mt-2 text-lg">Retrouvez l'ensemble de vos signalements enregistrés sur la plateforme.</p>
    </div>

    {{-- Si aucune déclaration --}}
    @if($declarations->isEmpty())
        <div class="max-w-3xl mx-auto text-center bg-white shadow-xl rounded-2xl p-10 border border-gray-200">
            <svg class="w-16 h-16 text-indigo-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <p class="text-gray-600 text-xl font-semibold mb-6">Aucune déclaration trouvée.</p>
            <a href="{{ route('declarations.create') }}"
               class="inline-block px-8 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 transition transform hover:scale-105 duration-300">
                Déclarer un nouveau problème
            </a>
        </div>
    @else
        {{-- Liste des déclarations --}}
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 fade-in">
            @foreach($declarations as $declaration)
                <div class="bg-white shadow-lg rounded-2xl p-6 transition transform hover:-translate-y-1 hover:shadow-2xl duration-300 border border-gray-100 flex flex-col justify-between">
                    
                    <div>
                        {{-- Type et Urgence/Suivi --}}
                        <div class="flex justify-between items-start mb-3">
                            <h2 class="text-xl font-bold text-gray-900 capitalize leading-tight">
                                {{ ucfirst(str_replace('_', ' ', $declaration->type)) }}
                            </h2>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full uppercase ml-3 flex-shrink-0
                                {{ $declaration->urgence ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-green-50 text-green-700 border border-green-200' }}">
                                {{ $declaration->urgence ? 'URGENCE' : 'Suivi' }}
                            </span>
                        </div>

                        {{-- Description --}}
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit($declaration->description, 100) }}
                        </p>

                        {{-- Localisation --}}
                        <div class="text-xs text-gray-500 mb-4 border-t pt-3 space-y-1">
                            @if($declaration->departement)
                                <p class="font-bold text-gray-700">Adresse Manuelle :</p>
                                <p>Département : <span class="font-medium text-gray-600">{{ $declaration->departement->name }}</span></p>
                                @if(optional($declaration->commune)->name)
                                    <p>Commune : <span class="font-medium text-gray-600">{{ optional($declaration->commune)->name }}</span></p>
                                @endif
                                @if(optional($declaration->arrondissement)->name)
                                    <p>Arrondissement : <span class="font-medium text-gray-600">{{ optional($declaration->arrondissement)->name }}</span></p>
                                @endif
                                @if($declaration->quartier)
                                    <p>Quatier : <span class="font-medium text-gray-600">{{ $declaration->quartier }}</span></p>
                                @endif

                                @if($declaration->rue)
                                    <p>Rue : <span class="font-medium text-gray-600">{{ $declaration->rue }}</span></p>
                                @endif

                                @if($declaration->maison)
                                    <p>Maison : <span class="font-medium text-gray-600">{{ $declaration->maison }}</span></p>
                                @endif

                            @elseif($declaration->latitude && $declaration->longitude)
                                <p class="font-bold text-gray-700">Géolocalisation :</p>
                                <a target="_blank" href="https://maps.google.com/maps?q={{ $declaration->latitude }},{{ $declaration->longitude }}"
                                   class="text-blue-600 hover:text-blue-800 transition flex items-center mt-1">
                                    Voir la position sur la carte
                                </a>
                            @else
                                <p>Localisation non précisée</p>
                            @endif
                        </div>
                    </div>

                    {{-- Médias (Mise en page compacte) --}}
                    @if($declaration->medias->count() > 0)
                        <div class="mt-4 pt-3 border-t">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Pièces jointes ({{ $declaration->medias->count() }}) :</p>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($declaration->medias->take(4) as $media) {{-- Limité à 4 pour la vignette --}}
                                    @if($media->type === 'image')
                                        <a href="{{ asset('storage/'.$media->path) }}" target="_blank" class="block group relative">
                                            <img src="{{ asset('storage/'.$media->path) }}"
                                                 class="rounded-lg w-full h-16 object-cover border border-gray-300 transition group-hover:opacity-75">
                                        </a>
                                    @else
                                        <div class="relative">
                                            <video controls class="rounded-lg w-full h-16 object-cover border border-gray-300">
                                                <source src="{{ asset('storage/'.$media->path) }}" type="video/mp4">
                                            </video>
                                            <span class="absolute top-1 right-1 bg-black/50 text-white text-xs px-1 rounded">Vidéo</span>
                                        </div>
                                    @endif
                                @endforeach
                                @if($declaration->medias->count() > 4)
                                    <div class="flex items-center justify-center h-16 w-full rounded-lg bg-gray-200 text-gray-600 text-xs font-medium">
                                        +{{ $declaration->medias->count() - 4 }} autres
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Pied de carte --}}
                    <div class="mt-6 text-xs text-gray-400 border-t pt-4">
                        Soumis le **{{ $declaration->created_at->format('d/m/Y') }}** à {{ $declaration->created_at->format('H:i') }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Animation simple --}}
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-15px); }
    to { opacity: 1; transform: translateY(0); }
}
.fade-in {
    animation: fadeIn 0.4s ease-in-out;
}
.animate-fadeInDown {
    animation: fadeInDown 0.6s ease-out;
}
</style>
@endsection