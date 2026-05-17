<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filme extends Model
{
    protected $table = 'filme';

    protected $fillable = [
        'nome',
        'duracao',
        'data_lancamento',
        'classificacao',
        'sinopse',
    ];

    protected function casts(): array
    {
        return [
            'data_lancamento' => 'date',
        ];
    }

    public function atores(): BelongsToMany
    {
        return $this->belongsToMany(Ator::class, 'ator_filme')
            ->withPivot('papel')
            ->withTimestamps();
    }

    public function diretores(): BelongsToMany
    {
        return $this->belongsToMany(Diretor::class, 'diretor_filme')->withTimestamps();
    }

    public function produtores(): BelongsToMany
    {
        return $this->belongsToMany(Produtor::class, 'produtor_filme')->withTimestamps();
    }

    public function escritores(): BelongsToMany
    {
        return $this->belongsToMany(Escritor::class, 'escritor_filme')->withTimestamps();
    }

    public function generos(): BelongsToMany
    {
        return $this->belongsToMany(Genero::class, 'filme_genero')->withTimestamps();
    }

    public function estudios(): BelongsToMany
    {
        return $this->belongsToMany(Estudio::class, 'estudio_filme')->withTimestamps();
    }

    public function imagens(): BelongsToMany
    {
        return $this->belongsToMany(Imagem::class, 'imagem_filme')->withTimestamps();
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }
}
