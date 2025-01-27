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
                return ' <a class="btn-sm btn btn-info previewButton d-grid gap-2 click" data-id="' . $row->id . '" href="#" data-bs-toggle="modal" data-bs-target="#eventPreviewModal">Előnézet</a>
                <a href="javascript:void(0)" class="btn-sm btn btn-secondary editButton d-grid gap-2" data-event_id="' . $row->id . '" >Szerkeszt</a>
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
        return view("events.create");
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
            'picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'type' => 'required|string',
            'description' => 'required|string',
        ]);
        $data['creator_id'] = Auth::user()->id;
        $image=$request->file('picture');
        $new_name=rand().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);

        $data["picture"]= $new_name;

        if ($request->event_edit != null) {
            $event = Event::findOrFail($request["event_id"]);

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
            Event::create($data);

            return response()->json([
                'success' => 'Sikeres verseny felvétel'
            ], 201);
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
     * Redirect to the Home page 
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        // Alapértelmezett lekérdezés
        $query = Event::leftJoin('invitees', 'events.id', '=', 'invitees.event_id')
            ->where(function ($query) {
                $query->where('events.type', 'public')
                    ->orWhere(function ($query) {
                        $query->where('events.type', 'private')
                            ->where('invitees.user_id', Auth::user()->id);
                    });
            })
            ->select('events.*')
            ->distinct()
            ->orderBy('events.date', 'desc');

        $query = $this->searchLocation(request(), $query);
        $query = $this->searchDescription(request(), $query);
        $query = $this->searchName(request(), $query);
        $query = $this->searchType(request(), $query);
        $query = $this->searchFromDate(request(), $query);
        $query = $this->searchToDate(request(), $query);

        $events = $query->get();

        return view("welcome", ["events" => $events]);
    }

    /**
     * Redirect to the Events page 
     * @return \Illuminate\Contracts\View\View
     */
    public function showUserEvent()
    {
        $query = Event::leftJoin('invitees', 'events.id', '=', 'invitees.event_id')
            ->where(function ($query) {
                $query->where('invitees.user_id', Auth::user()->id)
                    ->orWhere('events.creator_id', Auth::user()->id);
            })
            ->select('events.*')
            ->distinct()
            ->orderBy('events.date', 'desc');

        $query = $this->searchLocation(request(), $query);
        $query = $this->searchDescription(request(), $query);
        $query = $this->searchName(request(), $query);
        $query = $this->searchType(request(), $query);
        $query = $this->searchFromDate(request(), $query);
        $query = $this->searchToDate(request(), $query);
        $events = $query->get();

        return view("user.events", ["events" => $events]);
    }

    public function searchLocation(Request $request, $query)
    {
        if ($request->has('searchLocation') && $request->get('searchLocation') !== '') {
            $searchLocation = $request->get('searchLocation');
            $query->where('location', 'like', '%' . $searchLocation . '%');
        }
        return $query;
    }

    public function searchDescription(Request $request, $query)
    {
        if (request()->has('searchDescription') && request()->get('searchDescription') !== '') {
            $searchDescription = request()->get('searchDescription');
            $query->where('description', 'like', '%' . $searchDescription . '%');
        }
        return $query;
    }

    public function searchName(Request $request, $query)
    {
        if (request()->has('searchName') && request()->get('searchName') !== '') {
            $searchName = request()->get('searchName');
            $query->where('name', 'like', '%' . $searchName . '%');
        }
        return $query;
    }

    public function searchType(Request $request, $query)
    {
        if (request()->has('searchType') && request()->get('searchType') !== '') {
            $searchType = request()->get('searchType');
            $query->where('type', 'like', '%' . $searchType . '%');
        }
        return $query;
    }

    public function searchFromDate(Request $request, $query)
    {
        if (request()->has('searchFromDate') && request()->get('searchFromDate') !== '') {
            $searchFromDate = request()->get('searchFromDate');
            $query->where('date', '>=', $searchFromDate);
        }
        return $query;
    }
    public function searchToDate(Request $request, $query)
    {
        if (request()->has('searchToDate') && request()->get('searchToDate') !== '') {
            $searchToDate = request()->get('searchToDate');
            $query->where('date', '<=', $searchToDate);
        }
        return $query;
    }
}
