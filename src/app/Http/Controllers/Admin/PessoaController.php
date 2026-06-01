<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Pessoa;
use App\Models\Produtor;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function index()
    {
        $pessoas = Pessoa::with('ator', 'diretor', 'produtor', 'escritor')->orderBy('nome')->paginate(20);
        return view('admin.pessoas.index', compact('pessoas'));
    }

    public function create()
    {
        return view('admin.pessoas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cpf'             => 'nullable|string|max:14|unique:pessoa,cpf',
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'nullable|date',
            'biografia'       => 'nullable|string',
            'genero'          => 'nullable|string|max:50',
            'nacionalidade'   => 'nullable|string|max:100',
        ]);

        $pessoa = Pessoa::create($data);
        $this->syncPapeis($pessoa, $request->input('papeis', []));

        return redirect()->route('admin.pessoas.index')->with('success', 'Pessoa criada com sucesso.');
    }

    public function edit(Pessoa $pessoa)
    {
        $pessoa->load('ator', 'diretor', 'produtor', 'escritor');
        return view('admin.pessoas.edit', compact('pessoa'));
    }

    public function update(Request $request, Pessoa $pessoa)
    {
        $data = $request->validate([
            'cpf'             => 'nullable|string|max:14|unique:pessoa,cpf,' . $pessoa->id,
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'nullable|date',
            'biografia'       => 'nullable|string',
            'genero'          => 'nullable|string|max:50',
            'nacionalidade'   => 'nullable|string|max:100',
        ]);

        $pessoa->update($data);
        $this->syncPapeis($pessoa, $request->input('papeis', []));

        return redirect()->route('admin.pessoas.index')->with('success', 'Pessoa atualizada com sucesso.');
    }

    public function destroy(Pessoa $pessoa)
    {
        $pessoa->delete();
        return redirect()->route('admin.pessoas.index')->with('success', 'Pessoa excluída com sucesso.');
    }

    private function syncPapeis(Pessoa $pessoa, array $papeis): void
    {
        if (in_array('ator', $papeis)) {
            Ator::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Ator::where('pessoa_id', $pessoa->id)->delete();
        }

        if (in_array('diretor', $papeis)) {
            Diretor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Diretor::where('pessoa_id', $pessoa->id)->delete();
        }

        if (in_array('produtor', $papeis)) {
            Produtor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Produtor::where('pessoa_id', $pessoa->id)->delete();
        }

        if (in_array('escritor', $papeis)) {
            Escritor::firstOrCreate(['pessoa_id' => $pessoa->id]);
        } else {
            Escritor::where('pessoa_id', $pessoa->id)->delete();
        }
    }
}
