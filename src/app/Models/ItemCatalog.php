<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCatalog extends Model
{
    protected $table = 'items_catalog';

    protected $fillable = [
        'name',
        'type',
        'subtype',
        'price',
        'spaces',
        'data',
        'description',
    ];

    protected $casts = [
        'price'  => 'integer',
        'spaces' => 'float',
        'data'   => 'array',
    ];
}
