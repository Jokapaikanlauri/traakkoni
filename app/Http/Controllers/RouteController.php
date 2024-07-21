<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.create') ;
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
     {
         $route = new Route;
         $route->start = $request->start;
         $route->end = $request->end;
         $route->waypoints = json_encode($request->waypoints);
         $route->distance = $request->distance;
         $route->elevation_gain = $request->elevation_gain;
         $route->save();
         error_log("store funktio");
         return to_route('home.index', $route)->with('message', 'Route was created');
     }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        return ('hello world!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        //
    }
    public function saveRoute(Request $request)
    {
        error_log("Saveroute");
        try {
            // Validate the incoming data
            $validated = $request->validate([
                'start' => 'required|array',
                'end' => 'required|array',
                'waypoints' => 'required|array',
                'elevationGain' => 'required|numeric',
                'totalDistance' => 'required|numeric',
                'name' => 'required|string'
            ]);
            error_log("validated");
            // Save the route data to the database
            $route = new Route();
            $route->name = $validated['name'];
            $route->start = json_encode($validated['start']); // Convert array to JSON
        $route->end = json_encode($validated['end']); // Convert array to JSON
            $route->waypoints = json_encode($validated['waypoints']);
            $route->distance = $validated['totalDistance'];
            $route->elevation_gain = $validated['elevationGain'];
            $route->save();
    
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
