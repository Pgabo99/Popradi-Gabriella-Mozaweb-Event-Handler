<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitees;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class InviteesController extends Controller
{

    /**
     * Returns the data from the Invitees table
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request,$event_id)
    {
        $invitees = Invitees::join('events', "events.id", "=", "invitees.event_id")
            ->join("users", "users.id", "=", "invitees.user_id")
            ->select('invitees.user_id', 'users.name as user_name', 'invitees.event_id', 'events.name as event_name')
            ->where("events.creator_id", "=", Auth::user()->id)
            ->where("events.id", "=", $event_id)
            ->get();
        if ($request->ajax()) {
            return DataTables::of($invitees)->addColumn('action', function ($row) {
                return '<a href="javascript:void(0)" class="btn-sm btn btn-danger deleteButton d-grid gap-2" data-event_id="' . $row->event_id . '" data-user_id="' . $row->user_id . '">Töröl</a>';
            })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Redirects to the Events page
     * @return \Illuminate\Contracts\View\View
     */
    public function create($event_id)
    {
        $users = User::leftJoin('invitees', function ($join) use ($event_id) {
            $join->on('invitees.user_id', '=', 'users.id')
                ->where('invitees.event_id', '=', $event_id);
        })
            ->whereNull('invitees.event_id')
            ->where("users.id", "!=", Auth::user()->id)
            ->select('users.id', 'users.name', "users.email")
            ->get();
        $event = Event::findOrFail($event_id);
        return view("invitees.create", ["users" => $users, "event" => $event]);
    }

    /**
     * Creates/Updates a Round
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|numeric',
            'event_id' => 'required|numeric',
            'confirmed' => 'string'
        ]);
        if ($request["edit"] != null) {
            DB::table("invitees")
                ->where('user_id', $data["user_id"])
                ->where('event_id', $data["event_id"])
                ->update($data);
        }
        if (Invitees::create($data)) {
            return response()->json([
                'success' => 'Sikeresen jelentkeztél'
            ], 201);
        }
    }

    /**
     * Summary of getOne
     * @param mixed $user_id
     * @param mixed $event_id
     * @return TModel|null
     */
    public function getOne($user_id, $event_id)
    {
        $invitees = Invitees::where('user_id', $user_id)->where('event_id', $event_id)->first();
        return $invitees;
    }

    /**
     * Summary of destroy
     * @param \Illuminate\Http\Request $request
     * @param mixed $user_id
     * @param mixed $event_id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $user_id, $event_id)
    {
        $deleted = DB::table('invitees')
            ->where('user_id', $user_id)
            ->where('event_id', $event_id)
            ->delete();
        if (!$deleted) {
            return response()->json([
                'error' => 'Sikertelen.'
            ], 404);
        }
        return response()->json([
            'success' => 'Sikeres törlés!'
        ], 204);
    }
}
