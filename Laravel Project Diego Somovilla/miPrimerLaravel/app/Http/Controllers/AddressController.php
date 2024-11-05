<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $emailValidator = $this->validateEmail($request);
        $addressValidator = $this->validateAddress($request);

        if ($emailValidator->fails() || $addressValidator->fails()) {
            return response()->json(['message' => 'Failed',
                'email' => $emailValidator->messages(),
                'address' => $addressValidator->messages()]);
        }
        $user = User::where('email', $request->get('email'))->firstOrFail();

        if ($user->address) {
            return response()->json(['message' => 'User has address already', 'data' => null], 404);
        }
        $address = new Address($addressValidator->validated());

        if($user->address()->save($address)){
            return response()->json(['message' => 'Address added successfully', 'data' => $address], 200);
        }
        return response()->json(['message' => 'Failed to add address', 'data' => null], 400);
    }
    public function validateEmail($request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|',
        ]);
    }
    public function validateAddress($request){
        return Validator::make($request->all(), [
            'country' => 'required|string|max:255',
            'zipcode'=>'required|string|max:6',
        ]);
    }
    public function show(Address $address)
    {
        return response()->json(['message' => 'Dirección encontrada', 'data' => $address], 200);
    }

    public function show_user(Address $address)
    {
        $alldata = array_merge($address->attributesToArray(), $address->user->attributesToArray());
        return response()->json(['message' => 'Usuario encontrado', 'data' => $alldata], 200);
    }
}
