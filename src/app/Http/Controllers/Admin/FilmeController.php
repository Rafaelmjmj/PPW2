<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Estudio;
use App\Models\Filme;
use App\Models\Genero;
use App\Models\Produtor;
use Illuminate\Http\Request;

class FilmeController extends Controller
{
    public function index()
    {
        $filmes = Filme::orderBy('nome')->paginate(20);
        return view('admin.filmes.index', compact('filmes'));
    }

    public function create()
    {
        return view('admin.filmes.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome'            => 'required|string|max:255',
            'duracao'         => 'nullable|integer|min:1',
            'data_lancamento' => 'nullable|date',
            'classificacao'   => 'nullable|string|max:50',
            'sinopse'         => 'nullable|string',
        ]);

        $filme = Filme::create($data);
        $this->syncRelacionamentos($filme, $request);

        return redirect()->route('admin.filmes.index')->with('success', 'Filme criado com sucesso.');
    }

    public function edit(Filme $filme)
    {
        $filme->load('generos', 'estudios', 'atores', 'diretores', 'produtores', 'escritores');
        return view('admin.filmes.edit', array_merge(['filme' => $filme], $this->formData()));
    }

    public function update(Request $request, Filme $filme)
    {
        $data = $request->validate([
            'nome'            => 'required|string|max:255',
            'duracao'         => 'nullable|integer|min:1',
            'data_lancamento' => 'nullable|date',
            'classificacao'   => 'nullable|string|max:50',
            'sinopse'         => 'nullable|string',
        ]);

        $filme->update($data);
        $this->syncRelacionamentos($filme, $request);

        return redirect()->route('admin.filmes.index')->with('success', 'Filme atualizado com sucesso.');
    }

    public function destroy(Filme $filme)
    {
        $filme->delete();
        return redirect()->route('admin.filmes.index')->with('success', 'Filme excluído com sucesso.');
    }

    private function formData(): array
    {
        return [
            'generos'   => Genero::orderBy('nome')->get(),
            'estudios'  => Estudio::orderBy('nome')->get(),
            'atores'    => Ator::with('pessoa')->get()->sortBy('pessoa.nome'),
            'diretores' => Diretor::with('pessoa')->get()->sortBy('pessoa.nome'),
            'produtores'=> Produtor::with('pessoa')->get()->sortBy('pessoa.nome'),
            'escritores'=> Escritor::with('pessoa')->get()->sortBy('pessoa.nome'),
        ];
    }

    private function syncRelacionamentos(Filme $filme, Request $request): void
    {
        $filme->generos()->sync($request->input('generos', []));
        $filme->estudios()->sync($request->input('estudios', []));
        $filme->diretores()->sync($request->input('diretores', []));
        $filme->produtores()->sync($request->input('produtores', []));
        $filme->escritores()->sync($request->input('escritores', []));

        $atoresSync = [];
        foreach ($request->input('atores', []) as $id => $dados) {
            if (!empty($dados['selecionado'])) {
                $atoresSync[$id] = ['papel' => $dados['papel'] ?? null];
            }
        }
        $filme->atores()->sync($atoresSync);
    }
}
