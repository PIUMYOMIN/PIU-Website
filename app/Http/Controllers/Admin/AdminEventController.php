<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Event;

class AdminEventController extends Controller
{
    public function index()
    {
       return view('admin.events.index',[
        'events' => Event::all(),
       ]);
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
       $data = request()->validate([
        'name' => 'required',
        'description' => 'required',
        'date' => 'required',
        'time' => 'required',
        'location' => 'required',
        'seat' => 'required',
        'city' => 'required',
        'country' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024'
       ]);

       $data['slug'] = Str::slug($data['name']);

       if($request->hasfile('image')){
        $data['image'] = $request->file('image')->store('event_images','public');
       };

       $data['user_id'] = auth()->user()->id;

       Event::create($data);

       return redirect('/admin/events');
    }

    public function edit(Event $event)
    {
       return view('admin.events.edit',[
        'event' => $event,
       ]);
    }

    public function update(Request $request, Event $event)
    {
       $data = request()->validate([
        'name' => 'required',
        'description' => 'required',
        'date' => 'required',
        'time' => 'required',
        'location' => 'required',
        'seat' => 'required',
        'city' => 'required',
        'country' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024'
       ]);

       $data['slug'] = Str::slug($data['name']);

       if($request->hasfile('image')){
        $data['image'] = $request->file('image')->store('event_images','public');
       };

       $data['user_id'] = auth()->user()->id;

       $event->update($data);

       return redirect('/admin/events');
    }

    public function delete(Event $event)
    {
        $event->delete();
        return redirect()->back();
    }
}