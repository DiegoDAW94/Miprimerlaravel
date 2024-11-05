<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Event;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|max:255|string',
            'c_password' => 'required|same:password',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->messages(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        return response()->json(['message' => 'User Created', 'data' => $user], 200);
    }

    public function show(User $user)
    {
        return response()->json(['message' => '', 'data' => $user], 200);
    }
    public function show_address(User $user){
        $alldata = array_merge($user->address->attributesToArray(),$user->attributesToArray());
        return response()->json(['message' => 'Dirección encontrada', 'data' => $alldata], 200);
    }
    public function bookEvent(Request $request, User $user,Event $event){
    $note = "";
    if($request->note){
      $note = $request->note;
    }
    if($user->events()->save($event, ['note' => $note])){
        return response()->json(['message' => 'Evento asignado', 'data' => $event], 200);
    }
    return response ()->json(['message'=>'Error','data'=>null],400);
    }
    public function listEvents(User $user){
        $events = $user->events;
        return response()->json(['message' => 'Eventos encontrados', 'data' => $events], 200);
    }
}
