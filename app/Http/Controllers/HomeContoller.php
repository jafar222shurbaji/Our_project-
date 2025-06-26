<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeContoller extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
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

    public function getProducts()
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
}
