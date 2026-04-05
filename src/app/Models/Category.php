<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //mana aja field yang harus di isi/tidak boleh diisi
    protected $guarded = ['id'];

    //costum route key name
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products(): Hasmany
    {
        return $this->hasMany(Product::class, 'category_slug', 'slug');
    }
}
