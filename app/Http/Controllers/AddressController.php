<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
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
        return Address::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idUser' => 'required',
            'houseNum' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postalCode' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $address = Address::create($validator->validate());
        return response()->json([
            'message' => 'Address successfully created',
            'comment' => $address
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Address::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Address::where("id",$id)->exists()) {
            $address = Address::find($id);
            $address->fill($request->only([
                'idUser',
                'houseNum',
                'street',
                'city',
                'state',
                'country',
                'postalCode'
            ]));
            $address->save();
            return response()->json([
                "message" => "Address updated successfully",
                'address' => $address
            ], 200);
        } else {
            return response()->json([
                "error" => "Address not found",
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Address::where('id', $id)->exists()){
            $address = Address::find($id);
            $address->delete();

            return response()->json([
                "message" => "Record deleted"
            ], 202);
        }else{
            return response()->json([
                "message" => "Address not found"
            ], 404);
        }
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
