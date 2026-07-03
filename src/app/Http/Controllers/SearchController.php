<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Filme;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $termo = trim($request->get('q', ''));

        if (empty($termo)) {
            return view('busca', ['termo' => $termo]);
        }

        $filmes = Filme::where('nome', 'ilike', "%{$termo}%")
            ->with('atores.pessoa', 'generos', 'imagens')
            ->orderBy('nome')
            ->get();

        $pessoas = Pessoa::where('nome', 'ilike', "%{$termo}%")
            ->with([
                'imagens',
                'ator.filmes.imagens',
                'diretor.filmes.imagens',
                'produtor.filmes.imagens',
                'escritor.filmes.imagens',
            ])
            ->orderBy('nome')
            ->get();

        $produtoras = Estudio::where('nome', 'ilike', "%{$termo}%")->orderBy('nome')->get();

        return view('busca', compact('termo', 'filmes', 'pessoas', 'produtoras'));
    }
}
