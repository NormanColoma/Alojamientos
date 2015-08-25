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
        'numeric' => 'El formato debe ser una cifra (para decimales usar punto. Ejemplo: 150.25)',
        'new-accom-main-img.max' => 'La imagen no puede ser mayor de 5mb',

    ];

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
        $size = 0;
        if($request->hasFile('new-accom-main-img')){
            $file = $request->file('new-accom-main-img');
            $photo = new Photo();
            $photo->setUrl($file->getClientOriginalName());
            $photo->setMain(true);
            $photos [] = $photo;
            if($request->hasFile('galery')) {
                $files = $request->file('galery');
                foreach($files as $f) {
                    $size = $size+$f->getClientSize();
                    $photo = new Photo();
                    $photo->setUrl($f->getClientOriginalName());
                    $photo->setMain(false);
                    $photos[] =$photo;
                }
            }
        }
        if($size > 30720000){
            return redirect('/manage/owner#newAccom')
                ->withErrors([
                    'galery' => 'La galería no puede pesar más de 30mb',
                ])
                ->withInput();
        }else {
            $validator = Validator::make($request->all(), [
                'new-accom-title' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
                'new-accom-city' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
                'new-accom-desc' => 'required',
                'new-accom-price' => 'required|numeric',
                'new-accom-main-img' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:5120',
            ], $this->messages);
            if ($validator->fails()) {
                return redirect('/manage/owner#newAccom')
                    ->withErrors($validator)
                    ->withInput();
            } else {
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
                    flash()->overlay('Tu alojamiento se ha anunciado correctamente. Puedes comprobarlo desde tu panel de control.', 'Publicado');
                    return redirect("/manage/owner");
                } catch (QueryException $ex) {
                    echo $ex;
                }

            }
        }


    }

    /**
     * Sube las imágenes del usuario a la carpeta correspondiente. Devuelte true en caso de que la subida sea correcta, y false
     * en caso contrario.
     *
     * @param  $file
     * @return Boolean
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
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateAccommodation(Request $request, $id)
    {
        return view("account/update_accom", ["id" => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function removeAccommodation($id)
    {
        $am = new AccommodationModel();
        if($am->deleteAccomm($id))
            return response()->json([ 'ok' => true, 'message' => 'Accomodation was delete' ], 200);
        else
            return response()->json([ 'ok' => false, 'message' => 'Accomodation was not found' ], 404);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function removePhoto($id)
    {
        return response()->json([ 'ok' => true, 'message' => 'Image was delete' ], 200);
        /*$am = new AccommodationModel();
        if($am->deletePhoto($id))
            return response()->json([ 'ok' => true, 'message' => 'Image was delete' ], 200);
        else
            return response()->json([ 'ok' => false, 'message' => 'Image was not found' ], 404);*/
    }
}
