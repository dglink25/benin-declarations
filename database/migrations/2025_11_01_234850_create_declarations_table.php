<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('declarations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // null si anonyme (urgence)
            $table->string('type'); // incendie, accident, etc.
            $table->text('description');
            $table->string('autre_type')->nullable();
            $table->boolean('urgence')->default(false);

            // Localisation manuelle
            $table->foreignId('departement_id')
                ->nullable()
                ->constrained('departements')
                ->nullOnDelete();

            $table->foreignId('commune_id')
                ->nullable()
                ->constrained('communes')
                ->nullOnDelete();

            $table->foreignId('arrondissement_id')
                ->nullable()
                ->constrained('arrondissements')
                ->nullOnDelete();

            $table->string('quartier')->nullable();
            $table->string('rue')->nullable();
            $table->string('maison')->nullable();

            // Localisation GPS
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('statut')->default('en attente'); // en attente, en cours, résolu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('declarations');
    }
};
