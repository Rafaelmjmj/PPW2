<?php

namespace App\Http\Controllers;

use App\Models\Filme;

class FilmePublicoController extends Controller
{
    public function show(Filme $filme)
    {
        $filme->load(
            'generos', 'estudios',
            'atores.pessoa', 'diretores.pessoa', 'produtores.pessoa', 'escritores.pessoa',
            'imagens',
            'avaliacoes.user'
        );
        return view('filmes.show', compact('filme'));
    }
}
