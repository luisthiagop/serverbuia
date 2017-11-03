<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seguidor extends Model
{
    protected $table = 'seguidores';

    protected $primaryKey = ['seguidores', 'seguidor'];

    protected $fillable = ['seguidores', 'seguidor'];
}
