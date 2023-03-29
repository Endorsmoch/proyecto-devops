<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|string',
            'manufacturer' => 'required|string',
            'price' => 'required',
            'stock' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $product = Product::create($validator->validate());
        return response()->json([
            'message' => 'Product successfully created',
            'product' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Product::where("id",$id)->exists()) {
            $product = Product::find($id);
            $product->fill($request->only([
                'name',
                'description',
                'price',
                'manufacturer',
                'stock'
            ]));
            $product->save();
            return response()->json([
                "message" => "Product updated successfully",
                'product' => $product
            ], 200);
        } else {
            return response()->json([
                "error" => "Product not found",
            ], 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            $product ->delete();
            return response()->json([
                "message" => "Product deleted successfully",
            ], 202);
        } else {
            return response()->json([
                "error" => "Product not found",
            ], 404);
        }
    }
}
