<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        try {
            return Product::all();
        } catch (\Exception $e) {
            Log::error("Error while getting all products: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while getting all products'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::debug('Store product request body: '. $request->getContent());
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required|string',
                'manufacturer' => 'required|string',
                'price' => 'required',
                'stock' => 'required'
            ]);
            if ($validator->fails()) {
                Log::warning("Validation failed while store product operation: ".implode('|',$validator->errors()->all()));
                return response()->json($validator->errors()->toJson(), 400);
            }
            $product = Product::create($validator->validate());
            return response()->json([
                'message' => 'Product successfully created',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            Log::error("Error while storing product: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while storing product'], 500);
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $method_name = 'show()';
        try {
            $product = Product::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
            $this->logProductNotFound($method_name);
            return response()->json(['error' => 'Product not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error while looking for the product with ID {$id}: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while looking for the product'], 500);
        }
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $method_name = 'update()';
        try {
            Log::debug('Update product request body: '. $request->getContent());
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
                $this->logProductNotFound($method_name);
                return response()->json([
                    "error" => "Product not found",
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while updating product with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while updating product'], 500);
        }
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $method_name = 'destroy()';
        try {
            if (Product::where('id', $id)->exists()) {
                $product = Product::find($id);
                $product ->delete();
                return response()->json([
                    "message" => "Product deleted successfully",
                ], 202);
            } else {
                $this->logProductNotFound($method_name);
                return response()->json([
                    "error" => "Product not found",
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while deleting product with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while deleting product'], 500);
        }
        
    }

    private function logProductNotFound(String $method) {
        Log::warning("Product not Found while calling $method method in ProductController.");
    }

    public function getMethodIndex() 
    {
        return $this->index();
    }

    public function getMethodStore(Request $request){
        return  $this->store($request);
    }

    public function getMethodShow(string $id)
    {
        return $this->show($id);
    }

    public function getMethodUpdate(Request $request, string $id) 
    {
        return $this->update($request, $id);
    }

    public function getMethodDestroy(string $id) 
    {
        return $this->destroy($id);
    }
}
