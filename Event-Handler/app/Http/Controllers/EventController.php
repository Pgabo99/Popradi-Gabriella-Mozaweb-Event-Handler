<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Auth;
use DB;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{

    /**
     * Returns the data from the Events table
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $events = Event::select('id', 'name', 'date', 'location', 'picture', 'type', 'description')->where('creator_id', Auth::user()->id)->get();
        if ($request->ajax()) {
            return DataTables::of($events)->addColumn('action', function ($row) {
                return '<a href="javascript:void(0)" class="btn-sm btn btn-secondary editButton d-grid gap-2" data-event_id="' . $row->id . '" >Szerkeszt</a>
                <a href="javascript:void(0)" class="btn-sm btn btn-danger deleteButton d-grid gap-2" data-event_id="' . $row->id . '">Töröl</a>';
            })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Redirects to the Events page
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $events = Event::select('id', 'name', 'date', 'location', 'picture', 'type', 'description')->where('creator_id', Auth::user()->id);
        return view("events.create", ["events" => $events]);
    }

    /**
     * Creates/Updates a Round
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'picture' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'required',
        ]);
        $data['creator_id'] = Auth::user()->id;

        if ($request->event_edit != null) {
            $event = Event::findOrFail($request['event_id']);
            if ($data['name'] === $event['name'] && $data['date'] === $event['date'] && $data['location'] === $event['location'] && $data['picture'] === $event['picture'] && $data['type'] === $event['type'] && $data['description'] === $event['description'])
                return response()->json([
                    'success' => 'Nem változott semmi.'
                ], 200);
            $event->update([
                'name' => $data['name'],
                'date' => $data['date'],
                'location' => $data['location'],
                'picture' => $data['picture'],
                'type' => $data['type'],
                'description' => $data['description'],
            ]);
            return response()->json([
                'success' => 'Sikeres módosítás!'
            ], 201);

        } else {
            if (Event::create($data)) {
                return response()->json([
                    'success' => 'Sikeres verseny felvétel'
                ], 201);
            }
        }
    }

    /**
     * Returns the editable data, if it exists
     * @param mixed $id
     * @return TModel
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return $event;
    }

    /**
     *  Deletes the data, if it exists
     * @param \Illuminate\Http\Request $request
     * @param mixed $comp_name
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $event->delete();
        return response()->json([
            'success' => 'Sikeres törlés!'
        ], 204);
    }

    /**
     * Redirect to the Events page 
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        $events= Event::leftJoin('invitees','events.id','=','invitees.event_id')
        ->where(function ($query) {
            $query->where('events.type', 'public')
                  ->orWhere(function ($query) {
                      $query->where('events.type', 'private')
                            ->where('invitees.user_id', Auth::user()->id); 
                  });
        })
        ->select('events.*') 
        ->distinct() 
        ->get();
        return view("welcome", ["events" => $events]);
    }
}
