<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void{
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la contrainte unique si elle existe
            $table->dropUnique(['email']);

            // Rendre email nullable et non unique
            $table->string('email')->nullable()->change();
        });
    }

    public function down(): void{
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->change();
        });
    }
};

