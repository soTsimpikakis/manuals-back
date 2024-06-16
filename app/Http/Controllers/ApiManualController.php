<?php

namespace App\Http\Controllers;

use App\Models\Manual;
use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class ApiManualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $manual = Manual::create($request->all());

        if($request->materials) {
            $manual->materials()->createMany($request->materials);
        }

        return response()->json($manual, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Manual $manual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manual $manual)
    {
        //

        $manual->update($request->all());

        $manual->save();

        return response()->json($manual, 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manual $manual)
    {
        //
        $manual->delete();

        return response('', 204);
    }
}
