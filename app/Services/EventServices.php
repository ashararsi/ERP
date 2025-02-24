<?php

namespace App\Services;

use App\Models\Compain;

use App\Models\Event;
use Config;

use DataTables;
use Illuminate\Support\Str;
use Laravel\Ui\Tests\AuthBackend\AuthenticatesUsersTest;

class  EventServices
{
    public function index($request)
    {
        $perPage = $request->get('per_page', 20);
        $posts = Event::orderBy('created_at', 'desc')->paginate($perPage);
        return response()->json([
            'data' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'next_page_url' => $posts->nextPageUrl(),
            'prev_page_url' => $posts->previousPageUrl(),
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'eventTitle' => 'required|string|max:255',
            'eventType' => 'required|string|max:255',
            'startDate' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'nullable|date_format:H:i',
            'location' => 'required|string|max:255',
            'eventDescription' => 'required|string',
            // Add validation for the rest of the fields
        ]);

        // Create and store the event
        $event = Event::create($validatedData);
        return $event;

    }

    public function edit($id)
    {
        return Event::findOrFail($id);

    }

    public function update($request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'eventTitle' => 'required|string|max:255',
            'eventType' => 'required|string|max:255',
            'startDate' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'nullable|date_format:H:i',
            'location' => 'required|string|max:255',
            'eventDescription' => 'required|string',
            // Add validation for the rest of the fields
        ]);
        $event = Event::find($id);
        return $event->update($validatedData);

    }

    public function destroy($id)
    {
        $post = Event::findOrFail($id);
        if ($post) {
            $post->delete();
        }
    }
}
