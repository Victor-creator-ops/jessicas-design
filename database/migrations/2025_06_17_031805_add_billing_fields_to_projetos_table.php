<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Adiciona as colunas para área (m²) e pacote de horas.
     */
    public function up(): void
    {
        Schema::table('projetos', function (Blueprint $table) {
            // Adiciona as novas colunas após a coluna 'valor_contrato'
            $table->decimal('area_m2', 8, 2)->nullable()->after('valor_contrato');
            $table->decimal('pacote_horas', 8, 2)->nullable()->after('area_m2');
        });
    }

    /**
     * Reverse the migrations.
     * Remove as colunas se precisarmos reverter a migração.
     */
    public function down(): void
    {
        Schema::table('projetos', function (Blueprint $table) {
            $table->dropColumn('area_m2');
            $table->dropColumn('pacote_horas');
        });
    }
};