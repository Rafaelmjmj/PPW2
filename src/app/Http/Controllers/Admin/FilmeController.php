<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Estudio;
use App\Models\Filme;
use App\Models\Genero;
use App\Models\Imagem;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image;

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
        $request->validate([
            'nome'            => 'required|string|max:255',
            'duracao'         => 'nullable|integer|min:1',
            'data_lancamento' => 'nullable|date',
            'classificacao'   => 'nullable|string|max:50',
            'sinopse'         => 'nullable|string',
            'imagens.*'       => 'nullable|image|max:5120',
        ]);

        $filme = Filme::create($request->only(['nome', 'duracao', 'data_lancamento', 'classificacao', 'sinopse']));
        $this->syncRelacionamentos($filme, $request);
        $this->handleImageUpload($filme, $request);

        return redirect()->route('admin.filmes.index')->with('success', 'Filme criado com sucesso.');
    }

    public function show(Filme $filme)
    {
        $filme->load('generos', 'estudios', 'atores.pessoa', 'diretores.pessoa', 'produtores.pessoa', 'escritores.pessoa', 'imagens');
        return view('admin.filmes.show', compact('filme'));
    }

    public function edit(Filme $filme)
    {
        $filme->load('generos', 'estudios', 'atores', 'diretores', 'produtores', 'escritores', 'imagens');
        return view('admin.filmes.edit', array_merge(['filme' => $filme], $this->formData()));
    }

    public function update(Request $request, Filme $filme)
    {
        $request->validate([
            'nome'            => 'required|string|max:255',
            'duracao'         => 'nullable|integer|min:1',
            'data_lancamento' => 'nullable|date',
            'classificacao'   => 'nullable|string|max:50',
            'sinopse'         => 'nullable|string',
            'imagens.*'       => 'nullable|image|max:5120',
        ]);

        $filme->update($request->only(['nome', 'duracao', 'data_lancamento', 'classificacao', 'sinopse']));
        $this->syncRelacionamentos($filme, $request);
        $this->handleImageDelete($filme, $request);
        $this->handleImageUpload($filme, $request);

        return redirect()->route('admin.filmes.index')->with('success', 'Filme atualizado com sucesso.');
    }

    public function destroy(Filme $filme)
    {
        foreach ($filme->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminho);
        }
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

    private function handleImageUpload(Filme $filme, Request $request): void
    {
        if (!$request->hasFile('imagens')) return;

        Storage::disk('public')->makeDirectory('imagens/filmes');

        foreach ($request->file('imagens') as $file) {
            $filename     = Str::random(40) . '.jpg';
            $relativePath = 'imagens/filmes/' . $filename;
            $fullPath     = Storage::disk('public')->path($relativePath);

            Image::decode($file)->scaleDown(600, 400)->encode(new JpegEncoder(80))->save($fullPath);

            $imagem = Imagem::create([
                'caminho' => $relativePath,
                'nome'    => $file->getClientOriginalName(),
            ]);
            $filme->imagens()->attach($imagem->id);
        }
    }

    private function handleImageDelete(Filme $filme, Request $request): void
    {
        $ids = $request->input('deletar_imagens', []);
        if (empty($ids)) return;

        $imagens = Imagem::whereIn('id', $ids)->get();
        foreach ($imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminho);
            $filme->imagens()->detach($imagem->id);
            $imagem->delete();
        }
    }
}
