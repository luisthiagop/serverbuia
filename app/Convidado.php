<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convidado extends Model
{
    protected $table = "convidados";
    protected $primaryKey = ['user_id', 'festa_id'];
    protected $fillable = [
        'user_id',
        'tem_permissao_convite',
        'festa_id',
        'hora_entrada',
        'presenca'
    ];
    public $incrementing = false;
}
