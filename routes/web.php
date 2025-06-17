<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\ArquivoController;
use App\Http\Controllers\VersaoArquivoController;
use App\Http\Controllers\RegistroHorasController;
use App\Http\Controllers\PortalClienteController;
use App\Http\Controllers\ReportController;

// Rota pública principal
Route::get('/', function () {
    return view('welcome');
});

// Rotas de Autenticação (Login, Registro, etc.)
// O Laravel Breeze já cuida disso para nós.
require __DIR__ . '/auth.php';

// --- ROTAS PROTEGIDAS (PRECISA ESTAR LOGADO) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/versoes/{versao}/download', [App\Http\Controllers\VersaoArquivoController::class, 'download'])->name('versoes.download');

    // --- ROTAS DA EQUIPE (ADMIN E DESIGNERS) ---
    // Requisitos: RF01, RF03, RF05
    Route::middleware(['role:admin,designer'])->group(function () {
        Route::get('/kanban', [ProjetoController::class, 'kanban'])->name('projetos.kanban');
        Route::resource('projetos', ProjetoController::class);

        // Ações dentro de um projeto
        Route::post('/projetos/{projeto}/arquivos', [ArquivoController::class, 'store'])->name('projetos.arquivos.store');
        Route::get('/versoes/{versao}/download', [VersaoArquivoController::class, 'download'])->name('versoes.download');
        Route::post('/projetos/{projeto}/horas', [RegistroHorasController::class, 'store'])->name('projetos.horas.store');
        Route::post('/projetos/{projeto}/avancar-fase', [ProjetoController::class, 'avancarFase'])->name('projetos.avancarFase');
        // Rota para atualizar a fase de um projeto via drag-and-drop
        Route::patch('/projetos/{projeto}/update-fase', [App\Http\Controllers\ProjetoController::class, 'updateFase'])->name('projetos.updateFase');

    });

    // --- ROTAS DO ADMINISTRADOR (JESSICA) ---
    // Requisitos: RF01, RF02, RF06
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('clientes', ClienteController::class);
        Route::resource('designers', DesignerController::class);
        Route::get('/relatorio/rentabilidade/{projeto}', [ReportController::class, 'rentabilidadeProjeto'])->name('reports.rentabilidade');
    });

    // --- ROTAS DO PORTAL DO CLIENTE ---
    // Requisito: RF04
    Route::middleware(['role:cliente'])->prefix('portal')->name('portal.')->group(function () {
        Route::get('/meu-projeto', [PortalClienteController::class, 'show'])->name('projeto.show');
        Route::post('/versoes/{versao}/aprovar', [PortalClienteController::class, 'approveVersion'])->name('versoes.approve');
        Route::post('/versoes/{versao}/solicitar-alteracao', [PortalClienteController::class, 'requestChange'])->name('versoes.requestChange');
    });
});