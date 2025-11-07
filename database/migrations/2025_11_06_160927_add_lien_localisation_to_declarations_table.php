<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajouter la colonne lien_localisation à la table declarations.
     */
    public function up(): void
    {
        Schema::table('declarations', function (Blueprint $table) {
            $table->string('lien_localisation', 500)->nullable()->after('longitude');
        });
    }

    /**
     * Supprimer la colonne si on rollback.
     */
    public function down(): void
    {
        Schema::table('declarations', function (Blueprint $table) {
            $table->dropColumn('lien_localisation');
        });
    }
};
