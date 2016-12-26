<?php

namespace App\Models;

use App\Traits\Models\WithTranslationsTrait;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use Translatable;
    use WithTranslationsTrait;

    public $timestamps = false;

    protected $fillable = [
        'status',
        'image',
        'link',
        'status',
        'position',
        'title',
        'content'
    ];

    protected $translatedAttributes = [
        'title',
        'content'
    ];

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeVisible($query)
    {
        return $query->where('status', true);
    }

    public function scopePositionSorted($query, $order = 'ASC')
    {
        return $query->orderBy('position', $order);
    }
}
