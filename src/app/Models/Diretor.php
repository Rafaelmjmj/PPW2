<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Diretor extends Model
{
    protected $table = 'diretor';

    protected $fillable = ['pessoa_id'];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function filmes(): BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'diretor_filme')->withTimestamps();
    }
}
