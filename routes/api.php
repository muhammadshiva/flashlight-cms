<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Detail logged in user',
        'data' => $request->user(),
    ]);
});


Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
})->middleware(['auth:sanctum']);

require __DIR__ . '/auth.php';
