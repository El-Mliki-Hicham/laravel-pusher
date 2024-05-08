<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\<!--uc_name-->;
use Illuminate\Http\Request;
use Monolog\Formatter\GoogleCloudLoggingFormatter;
use App\Http\Requests\<!--uc_name-->Request;

class <!--uc_name-->Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = <!--uc_name-->::all();
        return response()->json([
            'status' => true,
            '<!--uc_name-->' => $list
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(<!--uc_name-->Request $request)
    {
        $<!--lc_names--> = New <!--uc_name-->;
        <!--columns_store-->
        $<!--lc_names-->->save();
        // ucfirst(__("models/salon.salon"))." ".__("has been added")
        return response()->json([
            'status' => true,
            '<!--uc_name-->' => $<!--lc_names-->,
            "msg"=>"has been added"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $<!--lc_names--> =  <!--uc_name-->::find($id);
        return response()->json([
            'status' => true,
            '<!--uc_name-->' => $<!--lc_names-->
        ]);
    }
   
    /**
     * Show the form for editing the specified resource.
     */
    public function find(string $id)
    {
        $<!--lc_names--> =  <!--uc_name-->::find($id);
        return response()->json([
            'status' => true,
            '<!--uc_name-->' => $<!--lc_names-->,
            "msg"=>"has been added"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(<!--uc_name-->Request $request, string $id)
    {
        $<!--lc_names--> = <!--uc_name-->::find($id);
        <!--columns_update-->
        $<!--lc_names-->->save();
        return response()->json([
            'status' => true,
            '<!--uc_name-->' => $<!--lc_names-->,
            "msg"=>"has been update"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = <!--uc_name-->::find($id)->delete();
        return response()->json([
            'status' => true,

            "msg"=>"has been deleted"
        ]);
    }
}
