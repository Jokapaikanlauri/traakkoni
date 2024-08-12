<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use App\Models\Comment;
class RouteController extends Controller
{

    public function index()
    {
        $routes = Route::query()
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('home.index', ['routes' => $routes]);
    }

    public function likeRoute(Request $request, Route $route)
    {
        $user = auth()->user();

        if ($route->isLikedByUser($user->id)) {
            return response()->json(['status' => 'error', 'message' => 'You have already liked this route'], 400);
        }

        $route->increment('likes');
        $route->likedByUsers()->attach($user->id);

        return response()->json(['status' => 'success', 'likes' => $route->likes]);
    }

    public function create()
    {
        return view('home.create');
    }

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



    public function show(Route $route)
    {
          if($route->id != request()->users()->id){
              abort(403);

             }
        return view('home.show', ['route' => $route]);
    }

    public function destroy(Route $route)
    {

        if ($route->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $route->delete();

        return redirect()->route('home.myroutes')->with('message', 'Route deleted successfully.');
    }

    public function addComment(Request $request, Route $route) {
        $request->validate(['content' => 'required|string']);
        $comment = new Comment([
            'user_id' => auth()->id(),
            'route_id' => $route->id,
            'content' => $request->content,
        ]);
        $route->comments()->save($comment);
        return back()->with('message', 'Comment added successfully');
    }
    public function saveRoute(Request $request)
    {
        try {

            $validated = $request->validate([
                'start' => 'required|array',
                'end' => 'required|array',
                'waypoints' => 'required|array',
                'elevationGain' => 'required|numeric',
                'totalDistance' => 'required|numeric',
                'name' => 'required|string'
            ]);


            $route = new Route();
            $route->user_id = auth()->id();
            $route->name = $validated['name'];
            $route->start = json_encode($validated['start']); 
            $route->end = json_encode($validated['end']); 
            $route->waypoints = json_encode($validated['waypoints']); 
            $route->distance = $validated['totalDistance'];
            $route->elevation_gain = $validated['elevationGain'];
            $route->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Error saving route: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
