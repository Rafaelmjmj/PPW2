<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function index()
    {
        $generos = Genero::orderBy('nome')->paginate(20);
        return view('admin.generos.index', compact('generos'));
    }

    public function create()
    {
        return view('admin.generos.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|string|max:100|unique:genero,nome']);
        Genero::create($request->only('nome'));
        return redirect()->route('admin.generos.index')->with('success', 'Gênero criado com sucesso.');
    }

    public function edit(Genero $genero)
    {
        return view('admin.generos.edit', compact('genero'));
    }

    public function update(Request $request, Genero $genero)
    {
        $request->validate(['nome' => 'required|string|max:100|unique:genero,nome,' . $genero->id]);
        $genero->update($request->only('nome'));
        return redirect()->route('admin.generos.index')->with('success', 'Gênero atualizado com sucesso.');
    }

    public function destroy(Genero $genero)
    {
        $genero->delete();
        return redirect()->route('admin.generos.index')->with('success', 'Gênero excluído com sucesso.');
    }
}
