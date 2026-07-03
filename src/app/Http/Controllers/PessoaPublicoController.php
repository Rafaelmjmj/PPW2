<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;

class PessoaPublicoController extends Controller
{
    public function show(Pessoa $pessoa)
    {
        $pessoa->load(
            'ator.filmes.imagens',
            'diretor.filmes.imagens',
            'produtor.filmes.imagens',
            'escritor.filmes.imagens',
            'imagens'
        );
        return view('pessoas.show', compact('pessoa'));
    }
}
