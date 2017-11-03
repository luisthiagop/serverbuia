<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagens';

    protected $fillable = [
        'user_id',
        'festa_id',
        'titulo',
        'texto'
    ];
}
