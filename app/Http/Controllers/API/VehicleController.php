<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index(): JsonResponse
    {
        $vehicles = Vehicle::orderBy('brand', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Get all vehicles',
            'data' => $vehicles,
        ]);
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Get vehicle details',
            'data' => $vehicle
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'engine_category' => 'required|in:100cc,200cc,600cc',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vehicle = Vehicle::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Vehicle created successfully',
            'data' => $vehicle
        ], 201);
    }

    public function update(Request $request, Vehicle $vehicle): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'engine_category' => 'sometimes|required|in:100cc,200cc,600cc',
            'brand' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $vehicle->update($request->only('engine_category', 'brand', 'model'));

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully',
            'data' => $vehicle
        ]);
    }

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully',
        ]);
    }
}
