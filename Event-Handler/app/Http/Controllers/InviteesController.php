<?php

namespace App\Http\Controllers;

use App\Models\Invitees;
use Illuminate\Http\Request;
use DB;

class InviteesController extends Controller
{
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

            return response()->json([
                'success' => 'Sikeresen jelentkeztél'
            ], 201);
        }
        if (Invitees::create($data)) {
            return response()->json([
                'success' => 'Sikeresen jelentkeztél'
            ], 201);
        }
    }

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
