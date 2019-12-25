<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Vol;
use App\Http\Resources\Vol as VolResource;
use Illuminate\Http\Request;

class VolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vols = Vol::paginate(10);

        // return une collection de vol comme une ressource
        return VolResource::collection($vols);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vol = $request->isMethod('put') ? Vol::findOrFail($request->vol_id) : new Vol;

        $vol->id = $request->input('vol_id');
        $vol->dateDepart = $request->input('dateDepart');
        $vol->heureDepart = $request->input('heureDepart');
        $vol->dateArrivee = $request->input('dateArrivee');
        $vol->heureArrivee = $request->input('heureArrivee');

        if($vol->save()){
            return new VolResource($vol);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vol = Vol::findOrFail($id);

        // return a single vol as a resource
        return new VolResource($vol);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vol = Vol::findOrFail($id);

        if($vol->delete()){
            return new VolResource($vol);
        }
    }
}
