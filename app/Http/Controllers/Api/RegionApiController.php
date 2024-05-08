<?php

namespace App\Http\Controllers\API;

use App\Events\RegionEvent;
use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Monolog\Formatter\GoogleCloudLoggingFormatter;
use App\Http\Requests\RegionRequest;

class RegionApiController extends  Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Region::all();
        return response()->json([
            'status' => true,
            'Region' => $list
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionRequest $request)
    {
        $region = new Region;
        $region->label = $request->label;

        $region->save();
        // ucfirst(__("models/salon.salon"))." ".__("has been added")
        event(new RegionEvent($region));

        // return response()->json([
        //     'status' => true,
        //     'Region' => $region,
        //     "msg" => "has been added"
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region =  Region::find($id);
        return response()->json([
            'status' => true,
            'Region' => $region
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function find(string $id)
    {
        $region =  Region::find($id);
        return response()->json([
            'status' => true,
            'Region' => $region,
            "msg" => "has been added"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegionRequest $request, string $id)
    {
        $region = Region::find($id);
        $region->label = $request->label;

        $region->save();
        return response()->json([
            'status' => true,
            'Region' => $region,
            "msg" => "has been update"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = Region::find($id)->delete();
        return response()->json([
            'status' => true,

            "msg" => "has been deleted"
        ]);
    }
}
