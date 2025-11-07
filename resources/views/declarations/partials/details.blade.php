<div class="p-6">
    <div class="flex justify-between items-start mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Détails de la Déclaration</h2>
        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
            &times;
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Informations principales --}}
        <div class="space-y-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold text-gray-700 mb-2">Informations</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Numéro:</span>
                        <span class="font-medium">#{{ str_pad($declaration->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-medium">{{ $declaration->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Statut:</span>
                        <span class="font-medium px-2 py-1 rounded-full text-xs 
                            @if($declaration->statut == 'traité') bg-green-100 text-green-800
                            @elseif($declaration->statut == 'en_cours') bg-yellow-100 text-yellow-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ $declaration->statut ?? 'Nouveau' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Urgence:</span>
                        <span class="font-medium {{ $declaration->urgence ? 'text-red-600' : 'text-green-600' }}">
                            {{ $declaration->urgence ? 'Oui' : 'Non' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Localisation --}}
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold text-gray-700 mb-2">Localisation</h3>
                <div class="space-y-2 text-sm">
                    @if($declaration->departement)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Département:</span>
                            <span class="font-medium">{{ $declaration->departement->name }}</span>
                        </div>
                    @endif
                    @if($declaration->commune)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Commune:</span>
                            <span class="font-medium">{{ $declaration->commune->name }}</span>
                        </div>
                    @endif
                    @if($declaration->arrondissement)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Arrondissement:</span>
                            <span class="font-medium">{{ $declaration->arrondissement->name }}</span>
                        </div>
                    @endif
                    @if($declaration->latitude && $declaration->longitude)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Coordonnées:</span>
                            <span class="font-medium text-xs">
                                {{ $declaration->latitude }}, {{ $declaration->longitude }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Description et Médias --}}
        <div class="space-y-4">
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="font-semibold text-gray-700 mb-2">Description</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $declaration->description }}</p>
            </div>

            @if($declaration->media->count() > 0)
                <div class="bg-gray-50 rounded-xl p-4">
                    <h3 class="font-semibold text-gray-700 mb-2">Médias</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($declaration->media as $media)
                            @if($media->type == 'image')
                                <img src="{{ Storage::url($media->path) }}" 
                                     alt="Image déclaration" 
                                     class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
                                     onclick="openImage('{{ Storage::url($media->path) }}')">
                            @elseif($media->type == 'video')
                                <video class="w-full h-24 object-cover rounded-lg" controls>
                                    <source src="{{ Storage::url($media->path) }}" type="video/mp4">
                                </video>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function openImage(src) {
    window.open(src, '_blank');
}
</script>