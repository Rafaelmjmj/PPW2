<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Filme;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    public function store(Request $request, Filme $filme)
    {
        $request->validate([
            'titulo'   => 'required|string|max:255',
            'nota'     => 'required|integer|min:0|max:10',
            'descricao'=> 'nullable|string|max:2000',
        ]);

        Avaliacao::create([
            'filme_id'  => $filme->id,
            'user_id'   => auth()->id(),
            'titulo'    => $request->titulo,
            'nota'      => $request->nota,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('filmes.show', $filme)->with('success', 'Avaliação enviada com sucesso!');
    }
}
