<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\FilmePublicoController;
use App\Http\Controllers\PessoaPublicoController;
use App\Http\Controllers\Admin\FilmeController;
use App\Http\Controllers\Admin\PessoaController;
use App\Http\Controllers\Admin\GeneroController;
use App\Http\Controllers\Admin\EstudioController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/busca', SearchController::class)->name('busca');

Route::get('/filmes/{filme}', [FilmePublicoController::class, 'show'])->name('filmes.show');
Route::post('/filmes/{filme}/avaliacoes', [AvaliacaoController::class, 'store'])->middleware('auth')->name('filmes.avaliacoes.store');
Route::get('/pessoas/{pessoa}', [PessoaPublicoController::class, 'show'])->name('pessoas.show');


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.index'))->name('index');
    Route::resource('filmes', FilmeController::class);
    Route::resource('pessoas', PessoaController::class);
    Route::resource('generos', GeneroController::class)->except(['show']);
    Route::resource('estudios', EstudioController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
