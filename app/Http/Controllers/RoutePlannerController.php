<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoutePlannerController extends Controller
{
    public function show()
    {
        return view('route-planner');
    }

    public function saveRoute(Request $request)
    {
        $data = $request->validate([
            'start' => 'required|string',
            'end' => 'required|string',
            'waypoints' => 'required|array'
        ]);

        // Process the waypoints as needed (e.g., save to database)
        // ...

        return response()->json(['status' => 'success']);
    }
}
