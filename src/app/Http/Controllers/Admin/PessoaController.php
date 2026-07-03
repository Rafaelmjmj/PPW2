<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ator;
use App\Models\Diretor;
use App\Models\Escritor;
use App\Models\Filme;
use App\Models\Imagem;
use App\Models\Pessoa;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Laravel\Facades\Image;

class PessoaController extends Controller
{
    public function index()
    {
        $pessoas = Pessoa::with('ator', 'diretor', 'produtor', 'escritor')->orderBy('nome')->paginate(20);
        return view('admin.pessoas.index', compact('pessoas'));
    }

    public function create()
    {
        $filmes = Filme::orderBy('nome')->get();
        return view('admin.pessoas.create', compact('filmes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'nullable|date',
            'biografia'       => 'nullable|string',
            'genero'          => 'nullable|string|max:50',
            'nacionalidade'   => 'nullable|string|max:100',
            'imagens.*'       => 'nullable|image|max:5120',
        ]);

        $pessoa = Pessoa::create($request->only(['nome', 'data_nascimento', 'biografia', 'genero', 'nacionalidade']));
        $this->syncPapeis($pessoa, $request->input('papeis', []));
        $this->syncFilmes($pessoa, $request->input('filmes', []));
        $this->handleImageUpload($pessoa, $request);

        return redirect()->route('admin.pessoas.index')->with('success', 'Pessoa criada com sucesso.');
    }

    public function show(Pessoa $pessoa)
    {
        $pessoa->load('ator.filmes', 'diretor.filmes', 'produtor.filmes', 'escritor.filmes', 'imagens');
        return view('admin.pessoas.show', compact('pessoa'));
    }

    public function edit(Pessoa $pessoa)
    {
        $pessoa->load('ator.filmes', 'diretor.filmes', 'produtor.filmes', 'escritor.filmes', 'imagens');

        $filmesVinculados = collect();
        if ($pessoa->ator)    $filmesVinculados = $filmesVinculados->merge($pessoa->ator->filmes->pluck('id'));
        if ($pessoa->diretor) $filmesVinculados = $filmesVinculados->merge($pessoa->diretor->filmes->pluck('id'));
        if ($pessoa->produtor)$filmesVinculados = $filmesVinculados->merge($pessoa->produtor->filmes->pluck('id'));
        if ($pessoa->escritor)$filmesVinculados = $filmesVinculados->merge($pessoa->escritor->filmes->pluck('id'));
        $filmesIds = $filmesVinculados->unique()->values()->toArray();

        $filmes = Filme::orderBy('nome')->get();
        return view('admin.pessoas.edit', compact('pessoa', 'filmes', 'filmesIds'));
    }

    public function update(Request $request, Pessoa $pessoa)
    {
        $request->validate([
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'nullable|date',
            'biografia'       => 'nullable|string',
            'genero'          => 'nullable|string|max:50',
            'nacionalidade'   => 'nullable|string|max:100',
            'imagens.*'       => 'nullable|image|max:5120',
        ]);

        $pessoa->update($request->only(['nome', 'data_nascimento', 'biografia', 'genero', 'nacionalidade']));
        $this->syncPapeis($pessoa, $request->input('papeis', []));
        $this->syncFilmes($pessoa, $request->input('filmes', []));
        $this->handleImageDelete($pessoa, $request);
        $this->handleImageUpload($pessoa, $request);

        return redirect()->route('admin.pessoas.index')->with('success', 'Pessoa atualizada com sucesso.');
    }

    public function destroy(Pessoa $pessoa)
    {
        foreach ($pessoa->imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminho);
        }
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

    private function syncFilmes(Pessoa $pessoa, array $filmeIds): void
    {
        $pessoa->refresh();

        if ($pessoa->ator)    $pessoa->ator->filmes()->sync($filmeIds);
        if ($pessoa->diretor) $pessoa->diretor->filmes()->sync($filmeIds);
        if ($pessoa->produtor)$pessoa->produtor->filmes()->sync($filmeIds);
        if ($pessoa->escritor)$pessoa->escritor->filmes()->sync($filmeIds);
    }

    private function handleImageUpload(Pessoa $pessoa, Request $request): void
    {
        if (!$request->hasFile('imagens')) return;

        Storage::disk('public')->makeDirectory('imagens/pessoas');

        foreach ($request->file('imagens') as $file) {
            $filename     = Str::random(40) . '.jpg';
            $relativePath = 'imagens/pessoas/' . $filename;
            $fullPath     = Storage::disk('public')->path($relativePath);

            Image::decode($file)->scaleDown(600, 400)->encode(new JpegEncoder(80))->save($fullPath);

            $imagem = Imagem::create([
                'caminho' => $relativePath,
                'nome'    => $file->getClientOriginalName(),
            ]);
            $pessoa->imagens()->attach($imagem->id);
        }
    }

    private function handleImageDelete(Pessoa $pessoa, Request $request): void
    {
        $ids = $request->input('deletar_imagens', []);
        if (empty($ids)) return;

        $imagens = Imagem::whereIn('id', $ids)->get();
        foreach ($imagens as $imagem) {
            Storage::disk('public')->delete($imagem->caminho);
            $pessoa->imagens()->detach($imagem->id);
            $imagem->delete();
        }
    }
}
