<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Filme;

class HomeController extends Controller
{
    public function __invoke()
    {
        $filmesCarousel = Filme::has('imagens')
            ->with('imagens', 'generos')
            ->withAvg('avaliacoes', 'nota')
            ->latest()
            ->take(8)
            ->get();

        $filmes = Filme::with('imagens')
            ->withAvg('avaliacoes', 'nota')
            ->orderByDesc('data_lancamento')
            ->take(12)
            ->get();

        $avaliacoes = Avaliacao::with('filme.imagens', 'user')
            ->whereNotNull('titulo')
            ->latest()
            ->take(12)
            ->get();

        return view('home', compact('filmesCarousel', 'filmes', 'avaliacoes'));
    }
}
