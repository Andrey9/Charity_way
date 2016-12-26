<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'manufacturer',
        'class',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
