<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('versoes_arquivo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arquivo_id')->constrained('arquivos')->onDelete('cascade');
            $table->foreignId('user_id')->comment('ID do usuário que fez o upload')->constrained('users');
            $table->integer('versao');
            $table->string('path_arquivo');
            $table->text('descricao')->nullable();
            $table->string('status')->default('pendente'); // pendente, aprovada, reprovada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versoes_arquivo');
    }
};
