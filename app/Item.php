<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    
    protected $table = "Itens";


    protected $fillable = ['festa_id', 'nome', 'preco_individual', 'quantidade'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
