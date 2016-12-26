<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use App\Traits\Models\WithTranslationsTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;
    use WithTranslationsTrait;

    public $timestamps = false;

    public $translatedAttributes = [
        'name',
        'meta_keywords',
        'meta_title',
        'meta_description',
    ];

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'position',
        'status',
        'meta_keywords',
        'meta_title',
        'meta_description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->with('parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        if (empty($value)) {
            $value = $this->attributes['name'];
        }

        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * @param $value
     */
    public function setParentIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['parent_id'] = null;
        } else {
            $this->attributes['parent_id'] = $value;
        }
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeVisible($query)
    {
        return $query->where('status', true);
    }

}
