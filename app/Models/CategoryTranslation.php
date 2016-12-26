<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'name',
        'category_id',
        'meta_title',
        'meta_title',
        'meta_description'
    ];
}
