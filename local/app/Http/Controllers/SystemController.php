<?php

namespace App\Http\Controllers;

use App\Models\SystemModel;
use DB;
use Illuminate\Database\QueryException;
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
            $c_in= date('Y-m-d', strtotime($request->input("check-in")));
            $c_out = date('Y-m-d', strtotime($request->input("check-out")));;
           return redirect("search/accommodations/".$request->input("city")."/checkIn/".$c_in."/checkOut/".$c_out."/page/1");
        }
        else{
            if($request->has("city"))
                return redirect("search/accommodations/".$request->input("city")."/page/1");
            else
                return view("search/display",["total" => 0]);

        }

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

        $sm = new SystemModel();
        $accommodations = $sm->allAcomByCity($city);
        if($accommodations != null)
            $items = DB::table("accommodations")->where('city',$city)->orWhere('province',$city)->paginate(5)->total();
        else
            $items = 0;
        return view("search/display", ['accommodations' => $accommodations, 'city' => $city, 'total' => $items]);

    }

    public function displayAccommodationsByDate($city, $check_in, $check_out){
        $sm = new SystemModel();
        $accommodations = $sm->allAccomByDates($city, $check_in, $check_out);
        if($accommodations != null) {
            $ids = DB::table('schedules')->where('day',$check_in)->orWhere('day',$check_out)->distinct()->lists("accommodation_id");
            $items = DB::table("accommodations")->whereNotIn("id",$ids)->where('city', $city)->orWhere('province', $city)->paginate(5)->total();
        }
        else
            $items = 0;

        return view("search/display", ['accommodations' => $accommodations, 'city' => $city, 'total' => $items]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showMessage($id)
    {
        $sm = new SystemModel();
        $message = $sm->getMessage($id);
        if($message != null){
            return response()->json([
                'ok' => false, 'message' => 'Message was retrieved', 'id' => $message->getId(),
                'from' => $message->getFrom(), 'to' => $message->getTo(), 'subject' => $message->getSubject(),
                'text' => $message->getText(), 'type' => $message->getType()], 200);
        }
        else
            return response()->json([ 'ok' => false, 'message' => 'Message was not found' ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function readMessage($id)
    {
        $sm = new SystemModel();
        try{
            if($sm->readMessage($id)){
                return response()->json(['ok' => false, 'message' => 'Message was read'], 200);
            }
            else
                return response()->json([ 'ok' => false, 'message' => 'Message is already read' ], 404);
        }catch(QueryException $ex){
            throw new \Exception($ex);
        }
    }

    public function deleteMessage($id){
        $sm = new SystemModel();
        if($sm->deleteMessage(id))
            return response()->json(['ok' => true, 'message' => 'Message was deleted'], 200);
        else
            return response()->json(['ok' => false, 'message' => 'Message was not found'], 404);
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
