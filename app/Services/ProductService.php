<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class ProductService
{
    public function getAll($perPage = 5)
    {
        return Product::with('images')->paginate($perPage);
    }

    public function search($name, $perPage = 15)
    {
        return Product::query()
            ->where('name', 'LIKE', '%' . $name . '%')
            ->with('images')
            ->paginate($perPage);
    }

    public function getByCategory($categoryId, $perPage = 5)
    {
        return Product::where('category_id', $categoryId)
            ->with('images')
            ->paginate($perPage);
    }

    public function getAllCategories()
    {
        return Category::all();
    }
}