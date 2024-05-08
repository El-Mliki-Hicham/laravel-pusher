<?php

namespace App\Http\Controllers;

use App\Models\Region;

use Illuminate\Http\Request;
use App\Http\Requests\RegionRequest;
use Monolog\Formatter\GoogleCloudLoggingFormatter;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Region::all();
        return view("region.index", compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view("region.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionRequest $request)
    {
        $region = new Region;
        $region->label = $request->label;

        $region->save();
        // ucfirst(__("models/salon.salon"))." ".__("has been added")
        return redirect("/region")->with("msg", ucfirst(__("models/region.region")) . " " . __("has been added"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region =  Region::find($id);
        return view("region.show", compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $region =  Region::find($id);
        return view("region.edit", compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegionRequest $request, string $id)
    {
        $region = Region::find($id);
        $region->label = $request->label;

        $region->save();
        return redirect("/region")->with("msg", ucfirst(__("models/region.region")) . " " . __("has been updated"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = Region::find($id)->delete();
        return redirect("/region")->with("msg", ucfirst(__("models/region.region")) . " " . __("has been deleted"));
    }
}
