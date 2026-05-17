<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pessoa extends Model
{
    protected $table = 'pessoa';

    protected $fillable = [
        'cpf',
        'nome',
        'data_nascimento',
        'biografia',
        'genero',
        'nacionalidade',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento' => 'date',
        ];
    }

    public function ator(): HasOne
    {
        return $this->hasOne(Ator::class);
    }

    public function diretor(): HasOne
    {
        return $this->hasOne(Diretor::class);
    }

    public function produtor(): HasOne
    {
        return $this->hasOne(Produtor::class);
    }

    public function escritor(): HasOne
    {
        return $this->hasOne(Escritor::class);
    }

    public function imagens(): BelongsToMany
    {
        return $this->belongsToMany(Imagem::class, 'imagem_pessoa', 'imagem_pessoa_id', 'imagem_id');
    }
}
