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
    public function index(Request $request)
    {
        //
        $manuals = Manual::all();

        return response()->json($manuals);
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
        return response()->json($manual);
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

    public function addMaterial (Request $request, Manual $manual) {
        $material = $manual->materials()->create($request->all());
        return response()->json($material, 201);
    }

    public function removeMaterial (Manual $manual, Material $material) {
        $material->delete();
        return response(status: 204);
    }

    public function publish (Manual $manual) {
        $manual->is_draft = false;
        $manual->save();

        return response(status: 201);
    }
}
