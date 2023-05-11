<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
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
            return Order::all();
        } catch (\Exception $e) {
            Log::error("Error while getting all orders: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while getting all orders'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::debug('Store order request body: '. $request->getContent());
            $validator = Validator::make($request->all(), [
                'idUser' => 'required',
                'idProduct' => 'required',
                'amount' => 'required',
                'paymentMethod' => 'required'
            ]);
            if ($validator->fails()) {
                Log::warning("Validation failed while store order operation: ".implode('|',$validator->errors()->all()));
                return response()->json($validator->errors()->toJson(), 400);
            }
            $order = Order::create($validator->validate());
            return response()->json([
                'message' => 'Order successfully created',
                'comment' => $order
            ],201);
        } catch (\Exception $e) {
            Log::error("Error while storing order: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while storing order'], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $method_name = 'show()';
        try {
            $order = Order::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
            $this->logOrderNotFound($method_name);
            return response()->json(['error' => 'Order not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error while looking for the order with ID {$id}: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while looking for the order'], 500);
        }

        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $method_name = 'update()';
        try {
            Log::debug('Update order request body: '. $request->getContent());
            if (Order::where("id",$id)->exists()) {
                $order = Order::find($id);
                $order->fill($request->only([
                    'idUser',
                    'idProduct',
                    'amount',
                    'paymentMethod'
                ]));
                $order->save();
                return response()->json([
                    "message" => "Order updated successfully",
                    'order' => $order
                ], 200);
            } else {
                $this->logOrderNotFound($method_name);
                return response()->json([
                    "error" => "Order not found",
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while updating order with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while updating order'], 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $method_name = 'destroy()';

        try {
            if(Order::where('id', $id)->exists()){
                $order = Order::find($id);
                $order->delete();
    
                return response()->json([
                    "message" => "Record deleted"
                ], 202);
            }else{
                $this->logOrderNotFound($method_name);
                return response()->json([
                    "message" => "Order not found"
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while deleting order with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while deleting order'], 500);
        }
        
    }

    private function logOrderNotFound(String $method) {
        Log::warning("Comment not Found while calling $method method in OrderController.");
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
