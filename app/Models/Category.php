<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';
    protected $fillable = ['name', 'icon'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/category-icons/' . $this->icon);
        }
        return null;
    }
}
