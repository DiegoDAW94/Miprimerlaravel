<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
class EventTypeController extends Controller
{
    public function listEvents(EventType $type){
        $events=$type->events;
        return response()->json(['message'=>null,'data'=>$events],200);
    }
    public function store(Request $request){
        $event=new EventType();
        $event=EventType::Create([
            'description'=>$request->get('description'),
        ]);
        return response()->json(['message'=>"Tipo creado",'data'=>$event],200);
    }
}
