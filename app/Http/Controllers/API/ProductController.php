<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request): JsonResponse
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Proses upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Buat produk baru
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Proses upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }

        // Update data produk
        $product->update($request->only('name', 'price', 'description', 'category_id', 'image'));

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        // Hapus produk
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
