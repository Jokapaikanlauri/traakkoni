<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;

class RouteController extends Controller
{
    public function saveRoute(Request $request)
    {
        $route = new Route;
        $route->start = $request->start;
        $route->end = $request->end;
        $route->waypoints = json_encode($request->waypoints);
        $route->distance = $request->distance;
        $route->elevation_gain = $request->elevation_gain;
        $route->save();

        return response()->json(['status' => 'success']);
    }
}
