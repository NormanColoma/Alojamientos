<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Recibe por parámetro, el filtrado de la búsqueda. Puede ser por Ciudad, o por Ciudad y fecha de salida y llegada.
     * Le pasa dicho filtrado al método correpondiente para que cargue la visa y los datos.
     *
     * @param  Request  $request
     * @return Response
     */
    public function search(Request $request)
    {
        if($request->has("check-in") && $request->has("check-out")) {
            return redirect("search/accommodations/".$request->input("city")."/checkin/".$request->input("check-in")."/checkout/".$request->input("check-out"));
        }
        else
            return redirect("search/accommodations/".$request->input("city"));
    }



    /**
     * Recibe por parámetro, la ciudad o provincia por la que se va a filtrar la búsqueda actual. Realiza dicha búsqueda, y
     * bindea los datos a la vista.
     *
     * @param  String  $city
     * @return View
     */
    public function displayAccommodationsByCity($city)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
