<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acompanhante extends Model
{
    protected $table = 'acompanhantes';

    protected $fillable = [
        'user_id',
        'festa_id',
        'sexo',
        'nome',
        'idade',
        'parentesco'
    ];
}
