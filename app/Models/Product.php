<?php

namespace App\Models;

use App\Traits\Models\WithTranslationsTrait;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;
    use WithTranslationsTrait;

    public $timestamps = false;

    protected $translatedAttributes = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $fillable = [
        'slug',
        'name',
        'manufacturer',
        'class',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'parent_id',
        'volume',
        'price',
        'status',
        'position',
        'image',
        'category_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id')->with('parent');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->with('translations');
    }

    public function getCategoryName(){
        return isset($this->category->name) ? $this->category->name : null;
    }

    public function order()
    {
        return $this->hasMany('App\Models\Order_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(Product::class, 'parent_id');
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

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getImageForSearchIndex()
    {
        return $this->image;
    }

    public function scopePositionSorted($query, $order = 'ASC')
    {
        return $query->orderBy('position', $order);
    }

}
