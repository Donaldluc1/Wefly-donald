<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\Http\Requests;
use App\Http\Resources\Reservation as ReservationResource;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::paginate(5);

        // return une collection de vol comme une ressource
        return ReservationResource::collection($reservations);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservation = $request->isMethod('put') ? Reservation::findOrFail($request->reservation_id) : new Reservation;

        $reservation->id = $request->input('reservation_id');
        $reservation->date = $request->input('date');
        $reservation->numero = $request->input('numero');
        $reservation->vol_id = $request->input('vol_id');

        if($reservation->save()){
            return new ReservationResource($reservation);
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
        $reservation = Reservation::findOrFail($id);

        // return a single vol as a resource
        return new ReservationResource($reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = reservation::findOrFail($id);

        if($reservation->delete()){
            return new reservationResource($reservation);
        }
    }
}
