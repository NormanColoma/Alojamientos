<?php

namespace App\Http\Controllers;

use App\Models\AccommodationModel;
use App\Models\DTO\Accommodation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Type\Collection;
use PhpParser\Node\Scalar\String_;
use App\Models\DTO\Photo;
use Auth;
use Validator;

class AccommodationController extends Controller
{

    private $am;
    private $messages = [
        'required' => 'El campo es obligatorio',
        'regex' => 'El formato introducido no es válido. Solo se permiten letras',
        'image' => 'El archivo debe ser una imagen (jpeg, png, bmp, gif, or jpg)',
        'numeric' => 'El formato debe ser una cifra (para decimales usar punto. Ejemplo: 150.25)'
    ];

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
     * Recibimos por parámetro los datos para insertar un nuevo alojamiento.
     *
     * @param  Request  $request
     * @return Response
     */
    public function addAccommodation(Request $request)
    {
        $am = new AccommodationModel();
        $accom = new Accommodation();
        $file = null;
        $files = null;
        $photos = [];
        if($request->hasFile('new-accom-main-img')){
            $file = $request->file('new-accom-main-img');
            $photo = new Photo();
            $photo->setUrl($file->getClientOriginalName());
            $photo->setMain(true);
            $photos [] = $photo;
            if($request->hasFile('galery')) {
                $files = $request->file('galery');
                foreach($files as $f) {
                    $photo = new Photo();
                    $photo->setUrl($f->getClientOriginalName());
                    $photo->setMain(false);
                    $photos[] =$photo;
                }
            }
        }

        $validator = Validator::make($request->all(), [
            'new-accom-title' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'new-accom-city' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'new-accom-province' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'new-accom-desc' => 'required',
            'new-accom-price' => 'required|numeric',
            'new-accom-main-img' => 'required|image|mimes:jpeg,jpg,bmp,png,gif',
        ],$this->messages);
        if ($validator->fails()) {
            return redirect('/manage/owner#newAccom')
                ->withErrors($validator)
                ->withInput();
        }
        else{
            $accom->setTitle($request->input('new-accom-title'));
            $accom->setCity($request->input('new-accom-city'));
            $accom->setProvince($request->input('new-accom-province'));
            $accom->setBaths($request->input('new-accom-baths'));
            $accom->setBeds($request->input('new-accom-beds'));
            $accom->setCapacity($request->input('new-accom-capacity'));
            $accom->setPrice($request->input('new-accom-price'));
            if ($request->has('new-accom-inside'))
                $accom->setInside($request->input('new-accom-inside'));
            if ($request->has('new-accom-outside'))
                $accom->setOutside($request->input('new-accom-outside'));
            $accom->setDesc($request->input('new-accom-desc'));
            $accom->setPhotos($photos);
            echo "good";
            try {
                $am->createAccom($accom, Auth::user()->id);
                if ($this->uploadPhoto($file)) {
                    if ($files != null) {
                        foreach ($files as $file) {
                            $this->uploadPhoto($file);
                        }
                    }
                }
                flash()->overlay('Tu alojamiento se ha anunciado correctamente. Puedes comprobarlo desde tu panel de control.','Publicado');
                return redirect("/manage/owner");
            } catch (QueryException $ex) {
                echo $ex;
            }

        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function uploadPhoto($file)
    {
        $fileName = $file->getClientOriginalName();
        $destinationPath = base_path() ."/resources/assets/img/accoms";
        try{
            $file->move($destinationPath, $fileName);
        }catch(FileException $ex){
            return false;
        }
       return true;
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


    public function checkRequest(Request $request){




        return true;
    }
}
