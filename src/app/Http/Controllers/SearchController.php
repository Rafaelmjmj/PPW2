<?php

namespace App\Http\Controllers;

use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Estudio;
use App\Models\Filme;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $termo = trim($request->get('q', ''));

        if (empty($termo)) {
            return view('busca', ['termo' => $termo]);
        }

        $filmes = Filme::where('nome', 'ilike', "%{$termo}%")->orderBy('nome')->get();

        $atores = Ator::whereHas('pessoa', fn ($q) => $q->where('nome', 'ilike', "%{$termo}%"))
            ->with('pessoa')->get()->sortBy('pessoa.nome');

        $diretores = Diretor::whereHas('pessoa', fn ($q) => $q->where('nome', 'ilike', "%{$termo}%"))
            ->with('pessoa')->get()->sortBy('pessoa.nome');

        $escritores = Escritor::whereHas('pessoa', fn ($q) => $q->where('nome', 'ilike', "%{$termo}%"))
            ->with('pessoa')->get()->sortBy('pessoa.nome');

        $produtoras = Estudio::where('nome', 'ilike', "%{$termo}%")->orderBy('nome')->get();

        return view('busca', compact('termo', 'filmes', 'atores', 'diretores', 'escritores', 'produtoras'));
    }
}
