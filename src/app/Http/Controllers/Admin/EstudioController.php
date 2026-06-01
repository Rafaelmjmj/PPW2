<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudio;
use Illuminate\Http\Request;

class EstudioController extends Controller
{
    public function index()
    {
        $estudios = Estudio::orderBy('nome')->paginate(20);
        return view('admin.estudios.index', compact('estudios'));
    }

    public function create()
    {
        return view('admin.estudios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:estudio,nome',
            'local' => 'nullable|string|max:255',
        ]);
        Estudio::create($request->only('nome', 'local'));
        return redirect()->route('admin.estudios.index')->with('success', 'Estúdio criado com sucesso.');
    }

    public function edit(Estudio $estudio)
    {
        return view('admin.estudios.edit', compact('estudio'));
    }

    public function update(Request $request, Estudio $estudio)
    {
        $request->validate([
            'nome' => 'required|string|max:255|unique:estudio,nome,' . $estudio->id,
            'local' => 'nullable|string|max:255',
        ]);
        $estudio->update($request->only('nome', 'local'));
        return redirect()->route('admin.estudios.index')->with('success', 'Estúdio atualizado com sucesso.');
    }

    public function destroy(Estudio $estudio)
    {
        $estudio->delete();
        return redirect()->route('admin.estudios.index')->with('success', 'Estúdio excluído com sucesso.');
    }
}
