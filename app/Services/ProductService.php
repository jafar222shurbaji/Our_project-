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

    public function create(array $data, $images = null)
    {
        $product = Product::create($data);

        if ($images) {
            $this->handleProductImages($product, $images);
        }

        return $product->load('images');
    }

    public function find($id)
    {
        return Product::with('images')->findOrFail($id);
    }

    public function update(Product $product, array $data, $images = null, $deleteImages = null)
    {
        $product->update($data);

        if ($deleteImages) {
            $this->deleteProductImages($product, $deleteImages);
        }

        if ($images) {
            $this->handleProductImages($product, $images);
        }

        return $product->load('images');
    }

    public function delete(Product $product)
    {
        // حذف الصور من التخزين
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        return $product->delete();
    }

    protected function handleProductImages(Product $product, $images)
    {
        $order = $product->images()->max('order') ?? -1;

        foreach ($images as $image) {
            $fileName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $fileName, 'public');

            $product->images()->create([
                'path' => $path,
                'order' => ++$order,
                'is_primary' => $product->images()->count() === 0
            ]);
        }
    }

    protected function deleteProductImages(Product $product, $imageIds)
    {
        foreach ($imageIds as $imageId) {
            $image = $product->images()->find($imageId);
            if ($image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }
    }
}
