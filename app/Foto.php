<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'fotos';

    protected $fillable = [
        'path',
        'aprovada',
        'festa_id',
        'user_id'
    ];
}
