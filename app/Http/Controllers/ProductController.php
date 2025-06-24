<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'available_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'color_id' => 'required|exists:colors,id',
            'fabric_id' => 'required|exists:fabrics,id',
            'wood_id' => 'required|exists:woods,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $product = $this->productService->create(
            $request->except('images'),
            $request->hasFile('images') ? $request->file('images') : null
        );

        return new ProductResource($product);
    }

    public function search(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ]);

        $products = $this->productService->search(
            $request->name,
            $request->input('per_page', 15)
        );

        return ProductResource::collection($products);
    }

    public function getProduct()
    {
        $products = $this->productService->getAll(5);
        return ApiResponse::successWithData(
            ProductResource::collection($products)->toArray(request()),
            'Products fetched successfully',
            200
        );
    }

    public function getProductByCategoryId(Request $request)
    {
        $request->validate([
            "category_id" => "required|integer",
        ]);

        $products = $this->productService->getByCategory(
            $request->category_id,
            5
        );

        return ApiResponse::successWithData(
            ProductResource::collection($products)->toArray(request()),
            'Products fetched successfully',
            200
        );
    }

    public function getcategories()
    {
        $categories = $this->productService->getAllCategories();
        return ApiResponse::successWithData(
            CategoryResource::collection($categories)->toArray(request()),
            'Categories fetched successfully',
            200
        );
    }

    public function show(Product $product)
    {
        $product = $this->productService->find($product->id);
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'description' => 'sometimes|required|string',
            'available_quantity' => 'sometimes|required|integer|min:0',
            'category_id' => 'sometimes|required|exists:categories,id',
            'color_id' => 'sometimes|required|exists:colors,id',
            'fabric_id' => 'sometimes|required|exists:fabrics,id',
            'wood_id' => 'sometimes|required|exists:woods,id',
            'images.*' => 'sometimes|required|image|mimes:jpeg,png,jpg|max:2048',
            'delete_images' => 'sometimes|array',
            'delete_images.*' => 'exists:product_images,id'
        ]);

        $product = $this->productService->update(
            $product,
            $request->except(['images', 'delete_images']),
            $request->hasFile('images') ? $request->file('images') : null,
            $request->input('delete_images')
        );

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return ApiResponse::success('Product deleted successfully');
    }
}
