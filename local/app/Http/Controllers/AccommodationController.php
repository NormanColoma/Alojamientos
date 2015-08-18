<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Type\Collection;
use PhpParser\Node\Scalar\String_;
use App\Models\DTO\Photo;

class AccommodationController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function addAccommodation(Request $request)
    {
        $file = $request->file('new-accom-main-img');
        $files = $request->file('galery');
        $photos = [];
        $photo = new Photo();
        $photo->setUrl($file->getClientOriginalName());
        $photo->setMain(true);
        $photos [] = $photo;
        //TODO::Here call createAccommodation method from AccommodationModel. If true, process images upload, else return false.
        if($this->uploadPhoto($file)){
            foreach($files as $file) {
                $photo = new Photo();
                $photo->setUrl($file->getClientOriginalName());
                $photos[] =$photo;
                $this->uploadPhoto($file);
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
        $destinationPath = base_path() ."/resources/assets/img/";
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
}
