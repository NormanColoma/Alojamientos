<?php

namespace App\Http\Controllers;

use App\Models\AccommodationModel;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;
use phpDocumentor\Reflection\DocBlock\Type\Collection;
use PhpParser\Node\Scalar\String_;
use App\Models\DTO\Photo;
use Auth;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
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
        $am = new AccommodationModel();
        $accomm = $am->accommodationByID($id);
        if($accomm != null)
            return view("accommodation/details", ["id" => $id, "accomm" => $accomm]);
        else
            return view("errors/503");
    }


    /**
     * Obtenemos el alojamiento pasado por la id, y cargamos la vista para actualizar el mismo.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function getAccommodation($id)
    {
        $am = new AccommodationModel();
        $accomm = $am->accommodationByID($id);
        if($accomm != null)
            return view("account/update_accom", ["id" => $id, "accommodation" => $accomm]);
        else
            return view("errors/503");
    }


    /**
     * Actualizamos el alojamiento que se corresponde con la id pasada.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function updateAccommodation(Request $request, $id)
    {
        $messages = [
            'required' => 'El campo es obligatorio',
            'regex' => 'El formato introducido no es válido. Solo se permiten letras',
            'image' => 'El archivo debe ser una imagen (jpeg, png, bmp, gif, or jpg)',
            'numeric' => 'El formato debe ser una cifra (para decimales usar punto. Ejemplo: 150.25)',
        ];

        $validator = Validator::make($request->all(), [
            'new-accom-title' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'new-accom-city' => 'required|regex:/^[A-Z]+[a-zA-ZÁÉÍÓÚáéíóuñÑ\s\']+$/',
            'new-accom-desc' => 'required',
            'new-accom-price' => 'required|numeric',
        ], $this->messages);
        if ($validator->fails()) {
            return redirect('/accommodation/'. $id . '/update')
                ->withErrors($validator)
                ->withInput();
        } else {
            $accom = new Accommodation();
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
            try {
                $am = new AccommodationModel();
                $am->updateAccomm($accom,$id);
                flash()->overlay('Las características de tu alojamiento han sido actualizadas correctamente.Si quieres cambiar la imagen principal, o la galería, puedes hacerlo desde esta página.', 'Actualizado');
                return redirect("/accommodation/". $id . "/update");
            } catch (QueryException $ex) {
                echo $ex;
            }
        }


    }

    /**
     * Eliminamos el alojamiento que se corresponde con la id pasada.
     *
     * @param  int  $id
     * @return Response
     */
    public function removeAccommodation($id)
    {
        $am = new AccommodationModel();
        $photos = $am->allPhotos($id);
        if($am->deleteAccomm($id)) {
            foreach($photos as $photo){
                $path = base_path() ."/resources/assets/img/accoms/" . $photo->getUrl();
                \File::delete($path);
            }
            return response()->json(['ok' => true, 'message' => 'Accomodation was delete'], 200);
        }
        else
            return response()->json([ 'ok' => false, 'message' => 'Accomodation was not found' ], 404);
    }


    /**
     * Eliminamos la imagen que se corresponde con la id pasada
     *
     * @param  int  $id
     * @return Response
     */
    public function removePhoto($id)
    {
        $am = new AccommodationModel();
        $path = base_path() ."/resources/assets/img/accoms/" . $am->photoUrl($id);
        if($am->deletePhoto($id)) {
            try {
                \File::delete($path);
                return response()->json(['ok' => true, 'message' => 'Image was delete'], 200);
            }catch (FileException $ex){
                throw new Exception($ex->getMessage());
            }
        }
        else
            return response()->json([ 'ok' => false, 'message' => 'Image was not found' ], 404);
    }

    /**
     * Actuliza la imagen que se le pasa
     *
     * @param  int  $id
     * @return Response
     */
    public function updatePhoto(Request $request, $id)
    {
        if($request->hasFile('new-accom-main-img')){
            $file = $request->file('new-accom-main-img');
            $url = $file->getClientOriginalName();
            $am = new AccommodationModel();
            $url_to_remove = $am->photoUrl($id);
            if($am->updatePhoto($id,$url)){
                if($this->uploadPhoto($file)){
                    $to_remove = base_path() ."/resources/assets/img/accoms/" . $url_to_remove;
                    try {
                        \File::delete($to_remove);
                        return response()->json([ 'ok' => true, 'message' => 'Image was updated' ], 200);
                    }catch (FileException $ex){
                        throw new Exception($ex->getMessage());
                    }
                }
                return response()->json([ 'ok' => false, 'message' => 'New image was not uploaded' ], 404);
            }
            else
                return response()->json([ 'ok' => false, 'message' => 'Image was not found' ], 404);

        }
        return response()->json([ 'ok' => false, 'message' => 'File is not present' ], 500);

    }


    /**
     * Actualiza la galería de imágenes
     *
     * @param  int  $id
     * @return Response
     */
    public function updateGallery(Request $request, $id)
    {
        $updated = true;
        if($request->hasFile('galery')) {
            $am = new AccommodationModel();
            $files = $request->file('galery');
            foreach($files as $f) {
                $photo = new Photo();
                $photo->setUrl($f->getClientOriginalName());
                $photo->setMain(false);
                if($am->addPhoto($photo,$id) != null){
                    if(!$this->uploadPhoto($f)){
                        $updated=false;
                        return response()->json([ 'ok' => false, 'message' => 'Image was not found' ], 404);
                    }
                }
                else
                    return response()->json([ 'ok' => false, 'message' => 'Image was not added' ], 404);
            }
            if($updated) {
                $photos = $am->getGallery($id);
                return response()->json(['ok' => true, 'message' => 'Gallery was updated', 'photos' => $photos], 200);
            }
        }
        return response()->json([ 'ok' => false, 'message' => 'There are no image files present' ], 500);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Añade el calendario de ocupación pasado por parámetro al alojamiento que se corresponde con la id pasada.
     * En caso de exister, deveolverá la vista con un mensaje. En caso contrario devolveremos un Json.
     */
    public function updateSchedule(Request $request, $id){
        $schedule = new Schedule();
        $schedule->setDays($request->input('calendar'));
        $schedule->format_calendar();
        $am = new AccommodationModel();
        if($am->addSchedule($id,$schedule)){
            flash()->overlay('El calendario de ocupación del alojamiento ha sido actualizado correctamente.', 'Calendario actualizado');
            return redirect("/accommodation/". $id . "/schedule/update");
        }
        else{
            flash()->error("Debes seleccionar al menos una fecha");
            return redirect("/accommodation/". $id . "/schedule/update");
        }

    }

    /**
     * Obtiene el calendario de ocupación del alojamiento que se corresponde con la id pasada por parámetro.
     * Se devolverá un Json indicando si la operación se realizó correctamente (true o false)  y un mensaje
     * indicando lo ocurrido
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getSchedule($id){
        $am = new AccommodationModel();
        $schedule = $am->getSchedule($id);
        if($schedule != null){
            $dates = [];
            foreach($schedule->getDays() as $sched){
                $d = strtotime($sched);
                $date = array('year' => date("Y",$d), 'month' => date("m",$d), 'day' => date("d",$d));
                $dates[] = $date;
            }
            return response()->json([ 'ok' => true, 'schedule' => $dates , 'message' => 'Schedule was retrieved'], 200);
        }
        else
            return response()->json([ 'ok' => false, 'message' => 'Schedule is empty' ], 200);

    }

    /**
     * Se elimina el calendario de ocupación del alojamiento que se corresponde con la id pasada por parámetro.
     * Se devuelve un Json en función del resultado.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSchedule($id){
        $am = new AccommodationModel();
        if($am->deleteSchedule($id)){
            return response()->json([ 'ok' => true, 'message' => 'Schedule was deleted'], 200);
        }
        else
            return response()->json([ 'ok' => false, 'message' => 'Schedule was not found'], 404);

    }
}
