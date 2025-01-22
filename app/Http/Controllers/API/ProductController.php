<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::withCount('category')->orderBy('name', 'desc')->paginate();

        return response()->json(
            [
                'success' => true,
                'message' => 'Get all products',
                'data' => $products
            ]
        );
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Get detail product',
            'data' => $product
        ]);
    }
}
