<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function index()
    {
        $routes = Route::query()
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('home.index', ['routes' => $routes]);
    }

    public function create()
    {
        return view('home.create') ;
    }
    // public function getAllRoutes()
    // {
    //     $routes = Route::all();
    //     return response()->json($routes);
    // }
    public function myroutes()
    {
        $routes = Route::query()
            ->where('user_id', request()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('home.myroutes', ['routes' => $routes]);
    }

     public function store(Request $request)
     {
         $route = new Route;
         $route->start = $request->start;
         $route->end = $request->end;
         $route->waypoints = json_encode($request->waypoints);
         $route->distance = $request->distance;
         $route->elevation_gain = $request->elevation_gain;
         $route->save();
         return to_route('home.index', $route)->with('message', 'Route was created');
     }

    /**
     * Display the specified resource.
     */
    
    public function show(Route $route)
    {
        //  if($route->id != request()->users()->id){
        //      abort(403);
             
        //      }
             return view('home.show', ['route'=>$route]);
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

        // Save the route data to the database
        $route = new Route();
        $route->user_id = auth()->id(); // Set the current user's ID
        $route->name = $validated['name'];
        $route->start = json_encode($validated['start']); // Convert array to JSON
        $route->end = json_encode($validated['end']); // Convert array to JSON
        $route->waypoints = json_encode($validated['waypoints']); // Convert array to JSON
        $route->distance = $validated['totalDistance'];
        $route->elevation_gain = $validated['elevationGain'];
        $route->save();

        return response()->json(['status' => 'success']);
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error saving route: ' . $e->getMessage());

        // Return a JSON response with the error
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
}
