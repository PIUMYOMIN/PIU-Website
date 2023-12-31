<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{

    public function index()
    {
       return view('user.events.index',[
        'events' => Event::all(),
       ]);
    }

    public function show($slug)
    {
        $event = Event::where('slug',$slug)->firstOrFail();
       return view('user.events.show',[
        'event' => $event,
       ]);
    }

    public function register($slug)
    {
        $event = Event::where('slug',$slug)->firstOrFail();
        return view('user.events.register',[
            'event' => $event,
        ]);
    }
}