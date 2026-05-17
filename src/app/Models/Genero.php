<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genero extends Model
{
    protected $table = 'genero';

    protected $fillable = ['nome'];

    public function filmes(): BelongsToMany
    {
        return $this->belongsToMany(Filme::class, 'filme_genero')->withTimestamps();
    }
}
