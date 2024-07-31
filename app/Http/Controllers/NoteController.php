<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function index()
    {
        return view('home.index');
    }

    public function create()
    {
        return view('home.create') ;
    }

    public function store(Request $request)
    {
        $data=$request->validate(['route' => ['required','string']]);

        $data['id'] = $request->user()->id;

        $route = Route::create($data);

        return to_route('route.show', $route)->with('message', 'Route was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        if($route->id != request()->users()->id){
        abort(403);
        }
        return view('route.show', ['route'=>$route]) ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        if($route->user_id != request()->user()->id){
            abort(403);
            }
        return view('route.edit', ['route'=>$route]) ;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        $data=$request->validate(['route' => ['required','string']]);
        if($route->user_id != request()->user()->id){
            abort(403);
            }
        $route->update($data);

        return to_route('route.show', $route)->with('message', 'Route was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        if($route->user_id != request()->user()->id){
            abort(403);
            }
        $route-> delete();

        return to_route('route.index')-> with('message', 'Route was deleted!');
    }
}
