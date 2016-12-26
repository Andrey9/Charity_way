<?php

namespace App\Models;

use App\Traits\Models\WithTranslationsTrait;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Done extends Model
{
    /*use WithTranslationsTrait;
    use Translatable;*/

    public $timestamps = false;

    protected $fillable = [
        'value',
        'content',
        'status',
        'position'
    ];

    /*protected $translatedAttributes = [
        'content'
    ];*/

    public function scopeVisible($query)
    {
        return $query->where('status', true);
    }

    public function scopePositionSorted($query, $order = 'ASC')
    {
        return $query->orderBy('position', $order);
    }
}
