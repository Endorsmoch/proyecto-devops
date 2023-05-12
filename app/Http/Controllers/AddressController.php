<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
        try {
            return Address::all();
        } catch (\Exception $e) {
            Log::error("Error while getting all addresses: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while getting all addresses'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            Log::debug('Store address request body: '. $this->obfuscateSensitiveData($requestContent));
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
                Log::warning("Validation failed while store address operation: ".implode('|',$validator->errors()->all()));
                return response()->json($validator->errors()->toJson(), 400);
            }
            $address = Address::create($validator->validate());
            return response()->json([
                'message' => 'Address successfully created',
                'comment' => $address
            ],201);
        } catch (\Throwable $th) {
            Log::error("Error while storing address: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while storing address'], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $method_name = 'show()';
        try {
            $address = Address::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e ) {
            $this->logAddressNotFound($method_name);
            return response()->json(['error' => 'Address not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error while looking for the address with ID {$id}: {$e->getMessage()}", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An error occurred while looking for the address'], 500);
        }
        return response()->json($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $method_name = 'update()';
        try {
            $requestContent = json_decode($request->getContent(), true);
            Log::debug('Update address request body: '. $this->obfuscateSensitiveData($requestContent));
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
                $this->logAddressNotFound($method_name);
                return response()->json([
                    "error" => "Address not found",
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while updating address with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while updating address'], 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $method_name = 'destroy()';
        try {
            if(Address::where('id', $id)->exists()){
                $address = Address::find($id);
                $address->delete();
    
                return response()->json([
                    "message" => "Record deleted"
                ], 202);
            }else{
                $this->logAddressNotFound($method_name);
                return response()->json([
                    "message" => "Address not found"
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error while deleting address with ID $id: $e->getMessage()", ['stacktrace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Error while deleting address'], 500);
        }
        
    }

    private function obfuscateSensitiveData(array $data) 
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->obfuscateSensitiveData($value);
            } elseif ($this->isSensitiveData($key)) {
                $data[$key] = '***'; // Ofuscar información sensible
            }
        }
    
        return json_encode($data);
    }

    private function isSensitiveData(string $key)
    {
        return in_array($key, ['houseNum', 'street', 'city', 'state', 'country', 'postalCode']);
    }

    private function logAdressNotFound(String $method) {
        Log::warning("Address not Found while calling $method method in AddressController.");
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
