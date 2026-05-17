<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Model
{
    protected $table = 'usuario';

    protected $fillable = [
        'email',
        'nome',
        'senha',
        'admin',
    ];

    protected $hidden = ['senha'];

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function fotoPerfil(): HasOne
    {
        return $this->hasOne(FotoPerfil::class);
    }
}
