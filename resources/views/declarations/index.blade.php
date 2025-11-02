@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-6">

    {{-- Titre --}}
    <div class="max-w-6xl mx-auto mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-800">Mes Déclarations</h1>
        <p class="text-gray-600 mt-2">Historique de vos signalements enregistrés sur la plateforme.</p>
    </div>

    {{-- Si aucune déclaration --}}
    @if($declarations->isEmpty())
        <div class="max-w-3xl mx-auto text-center bg-white shadow-lg rounded-xl p-8">
            <p class="text-gray-600 text-lg">Vous n’avez encore fait aucune déclaration.</p>
            <a href="{{ route('declarations.create') }}"
               class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                ➕ Faire une déclaration
            </a>
        </div>
    @else
        {{-- Liste des déclarations --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
            @foreach($declarations as $declaration)
                <div class="bg-white shadow-lg rounded-xl p-5 transition transform hover:-translate-y-1 hover:shadow-2xl duration-300">
                    
                    {{-- En-tête --}}
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold text-gray-800 capitalize">
                            {{ ucfirst(str_replace('_', ' ', $declaration->type)) }}
                        </h2>
                        <span class="px-3 py-1 text-xs rounded-full {{ $declaration->urgence ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $declaration->urgence ? 'Urgence' : 'Avec suivi' }}
                        </span>
                    </div>

                    {{-- Description --}}
                    <p class="text-gray-700 text-sm mb-4">
                        {{ $declaration->description }}
                    </p>

                    {{-- Localisation --}}
                    <div class="text-sm text-gray-500 mb-4">
                        @if($declaration->departement)
                            <p><strong>Localisation :</strong><br>
                                Département : <span class="font-medium text-gray-700">{{ $declaration->departement->name }}</span><br>
                                Commune : <span class="font-medium text-gray-700">{{ optional($declaration->commune)->name }}</span><br>
                                Arrondissement : <span class="font-medium text-gray-700">{{ optional($declaration->arrondissement)->name }}</span>
                            </p>
                        @elseif($declaration->latitude && $declaration->longitude)
                            <p> <a target="_blank" href="https://www.google.com/maps?q={{ $declaration->latitude }},{{ $declaration->longitude }}"
                                   class="text-blue-600 underline">
                                Voir sur Google Maps
                            </a></p>
                        @else
                            <p>Localisation non précisée</p>
                        @endif
                    </div>

                    {{-- Médias --}}
                    @if($declaration->medias->count() > 0)
                        <div class="grid grid-cols-3 gap-2 mb-3">
                            @foreach($declaration->medias as $media)
                                @if($media->type === 'image')
                                    <a href="{{ asset('storage/'.$media->path) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$media->path) }}"
                                             class="rounded-lg w-full h-24 object-cover hover:scale-105 transition">
                                    </a>
                                @else
                                    <video controls class="rounded-lg w-full h-24 object-cover">
                                        <source src="{{ asset('storage/'.$media->path) }}" type="video/mp4">
                                    </video>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    {{-- Date --}}
                    <div class="text-xs text-gray-400 text-right">
                        Soumis le {{ $declaration->created_at->format('d/m/Y à H:i') }}
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
.fade-in {
    animation: fadeIn 0.4s ease-in-out;
}
</style>
@endsection
