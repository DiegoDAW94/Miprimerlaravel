<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\EventType;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(['message' => 'Eventos encontrados', 'data' => $events], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validateEventData($request);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->messages()
            ], 400);
        }

        // Verificar manualmente si el event_type_id existe en la base de datos
        if ($request->has('event_type_id') && !EventType::find($request->get('event_type_id'))) {
            return response()->json(['message' => 'El ID de tipo de evento no es válido'], 400);
        }

        $event = Event::create([
            'event_name' => $request->get('event_name'),
            'event_detail' => $request->get('event_detail'),
            'event_type_id' => $request->get('event_type_id'),
        ]);

        return response()->json(['message' => 'Event Created', 'data' => $event], 200);
    }

    /**
     * Display the specified resource.
     */
    public function listUsers(Event $event)
    {
        $users = $event->users;
        return response()->json(['message' => null, 'data' => $users], 200);
    }

    public function validateEventData(Request $request)
    {
        return Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'event_detail' => 'nullable|string',
            'event_type_id' => 'nullable|integer',
        ]);
    }
}
