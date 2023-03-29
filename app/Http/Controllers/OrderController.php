<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

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
        return Order::all(); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idUser' => 'required',
            'idProduct' => 'required',
            'amount' => 'required',
            'paymentMethod' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $order = Order::create($validator->validate());
        return response()->json([
            'message' => 'Order successfully created',
            'comment' => $order
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Order::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
            return response()->json([
                "error" => "Order not found",
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Order::where('id', $id)->exists()){
            $order = Order::find($id);
            $order->delete();

            return response()->json([
                "message" => "Record deleted"
            ], 202);
        }else{
            return response()->json([
                "message" => "Order not found"
            ], 404);
        }
    }
}
