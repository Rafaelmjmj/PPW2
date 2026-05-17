<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoPerfil extends Model
{
    protected $table = 'foto_perfil';

    protected $fillable = ['usuario_id', 'nome', 'caminho'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}
