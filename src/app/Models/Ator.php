<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ator extends Model
{
    protected $table = 'ator';

    protected $fillable = ['pessoa_id'];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function filmes(): BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'ator_filme')
            ->withPivot('papel')
            ->withTimestamps();
    }
}
