<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 18/08/2015
 * Time: 21:18
 */

use App\Models\AccommodationModel;
use App\Models\UserModel;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;
use App\Models\DTO\Owner;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccommIntegrationTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Insertamos un alojamiento en la base de datos
     *
     * @return void
     * @group insertAccomm
     */
    public function testInsertAccomm(){

        $this->notSeeInDatabase('accommodations', ['title' => 'Casa rural']);

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $p1->setUrl('url/photo1');
        $p1->setMain(1);

        $p2->setUrl('url/photo2');
        $p2->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Elche');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(50);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        //Testeamos el método createAccom que inserta tanto en la tabla accommodations como en la tabla photos
        $accom = $am->createAccom($a1, $um->getID($owner->getEmail()));

        $this->SeeInDatabase('accommodations', ['title' => 'Casa rural']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo1']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo2']);

        //Testeamos el método AllPhotos
        $this->assertEquals(2, count($am->allPhotos($accom['id'])));

    }

    /**
     * Insertamos un alojamiento en la base de datos
     *
     * @return void
     * @group insertFailAccomm
     */
    public function testInsertFailAccomm(){

        //$this->notSeeInDatabase('accommodations', ['title' => 'Casa rural']);

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $p1->setUrl('url/photo1');
        $p1->setMain(1);

        $p2->setUrl('url/photo2');
        $p2->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        //No seteamos la ciudad para hacer que salte la excepción
        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(50);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        //Testeamos el método createAccom lanza la excepcion QueryException
        $accom = null;
        try{
            $accom = $am->createAccom($a1, $um->getID($owner->getEmail()));
        }catch(Exception $e){
            $this->assertEquals("Ha fallado la inserción", $e->getMessage());
        }

        //Comprobamos que no se ha insertado en la BD
        $this->notSeeInDatabase('accommodations', ['title' => 'Casa rural']);
        $this->notSeeInDatabase('photos', ['url' => 'url/photo1']);
        $this->notSeeInDatabase('photos', ['url' => 'url/photo2']);

        //Comprobamos que no se ha insertado ninguna foto
        $this->assertEquals(0, count($am->allPhotos($accom['id'])));

    }

    /**
     * Recuperamos un alojamiento de la base de datos
     *
     * @return void
     * @group getAccomm
     */
    public function testGetAccommByID(){

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $p1->setUrl('url/photo1');
        $p1->setMain(1);

        $p2->setUrl('url/photo2');
        $p2->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Elche');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(number_format((float)50, 2, '.', ''));
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        $prueba = $am->createAccom($a1, $um->getID($owner->getEmail()));
        $photos = $am->allPhotos($prueba['id']);
        $a1->setPhotos($photos);
        $a1->setID($prueba['id']);

        $this->assertEquals($a1, $am->accommodationByID($prueba['id']));
    }

    /**
     * Recuperamos un alojamiento de la base de datos
     *
     * @return void
     * @group getAccommFail
     */
    public function testFailGetAccommByID(){

        $am = new AccommodationModel();

        $this->assertNull($am->accommodationByID(100));
    }

    /**
     * Recuperamos los alojamientos que tiene un owner de la base de datos
     *
     * @return void
     * @group getAccommByOwner
     */
    public function testGetAccommByOwnerID(){

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $a2 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $p3 = new Photo();
        $p4 = new Photo();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];
        $arrayPhoto2 = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $p1->setUrl('url/photo1');
        $p1->setMain(1);

        $p2->setUrl('url/photo2');
        $p2->setMain(0);

        $p3->setUrl('url/photo3');
        $p3->setMain(1);

        $p4->setUrl('url/photo4');
        $p4->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $arrayPhoto2 [] = $p3;
        $arrayPhoto2 [] = $p4;

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Elche');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(number_format((float)50, 2, '.', ''));
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');
        $a1->setInitialDesc($a1->getDesc());

        $a2->setBaths(1);
        $a2->setBeds(2);
        $a2->setCapacity(3);
        $a2->setCity('Murcia');
        $a2->setDesc('Alojamiento de calidad media.');
        $a2->setInside('Descripción del interior del alojamiento.');
        $a2->setOutside('Descripción del exterior del alojamiento.');
        $a2->setPhotos($arrayPhoto2);
        $a2->setPrice(number_format((float)20, 2, '.', ''));
        $a2->setProvince('Murcia');
        $a2->setTitle('Casa en la ciudad');
        $a2->setInitialDesc($a2->getDesc());

        $prueba1 = $am->createAccom($a1, $um->getID($owner->getEmail()));
        $prueba2 = $am->createAccom($a2, $um->getID($owner->getEmail()));

        $a1->setID($prueba1['id']);
        $a2->setID($prueba2['id']);
        $a1->setPhotos($am->allPhotos($prueba1['id']));
        $a2->setPhotos($am->allPhotos($prueba2['id']));
        $resultado = [];
        $resultado[] = $a1;
        $resultado[] = $a2;

        $this->assertEquals($resultado, $am->accommodationByOwner($um->getID($owner->getEmail())));
    }

    /**
     * Testeamos que el método devuelva null si no existe el id del owner
     *
     * @return void
     * @group getAccommByOwnerFail
     */
    public function testFailGetAccommByOwnerID(){

        $am = new AccommodationModel();

        $this->assertNull($am->accommodationByOwner(100));
    }

    /**
     * Testeamos que el método actualice correctamente un alojamiento de la base de datos
     *
     * @return void
     * @group updateAccomm
     */
    public function testUpdateAccomm(){

        //$this->notSeeInDatabase('accommodations', ['title' => 'Casa rural']);

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $a2 = new Accommodation();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $p1->setUrl('url/photo1');
        $p1->setMain(1);

        $p2->setUrl('url/photo2');
        $p2->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Elche');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(number_format((float)50, 2, '.', ''));
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        $a2->setBaths(4);
        $a2->setBeds(6);
        $a2->setCapacity(20);
        $a2->setCity('Madrid');
        $a2->setDesc('Alojamiento de lujo.');
        $a2->setInside('Descripción del interior del alojamiento.');
        $a2->setOutside('Descripción del exterior del alojamiento.');
        $a2->setPrice(number_format((float)50, 2, '.', ''));
        $a2->setProvince('Madrid');
        $a2->setTitle('Bungalow');

        $accom = $am->createAccom($a1, $um->getID($owner->getEmail()));

        $this->SeeInDatabase('accommodations', ['title' => 'Casa rural', 'city' => 'Elche']);

        $this->assertTrue($am->updateAccomm($a2, $accom['id']));
        $this->SeeInDatabase('accommodations', ['title' => 'Bungalow']);
        $this->SeeInDatabase('accommodations', ['city' => 'Madrid']);

    }

    /**
     * Testeamos que el método no actualice correctamente un alojamiento de la base de datos
     *
     * @return void
     * @group updateAccommFail
     */
    public function testUpdateAccommFail(){

        $this->notSeeInDatabase('accommodations', ['title' => 'Casa rural']);

        $am = new AccommodationModel();
        $a2 = new Accommodation();
        $owner = new Owner();
        $um = new UserModel();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $a2->setBaths(4);
        $a2->setBeds(6);
        $a2->setCapacity(20);
        $a2->setCity('Madrid');
        $a2->setDesc('Alojamiento de lujo.');
        $a2->setInside('Descripción del interior del alojamiento.');
        $a2->setOutside('Descripción del exterior del alojamiento.');
        $a2->setPrice(number_format((float)50, 2, '.', ''));
        $a2->setProvince('Madrid');
        $a2->setTitle('Bungalow');

        $this->assertFalse($am->updateAccomm($a2, 1));

    }

    /**
     * Testeamos que el método elimine correctamente un alojamiento de la base de datos
     *
     * @return void
     * @group deleteAccomm
     */
    public function testDeleteAccomm(){

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $p1->setUrl('url/photo1');
        $p1->setMain(1);

        $p2->setUrl('url/photo2');
        $p2->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Elche');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(50);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        $accom = $am->createAccom($a1, $um->getID($owner->getEmail()));

        $this->SeeInDatabase('accommodations', ['title' => 'Casa rural']);

        $this->assertTrue($am->deleteAccomm($accom['id']));

        $this->notSeeInDatabase('accommodations', ['title' => 'Casa rural']);
    }

    /**
     * Testeamos que el método NO elimine correctamente un alojamiento de la base de datos
     *
     * @return void
     * @group deleteAccommFail
     */
    public function testDeleteAccommFail(){
        $am = new AccommodationModel();

        $result = $am->deleteAccomm(1);

        $this->assertFalse($result);

    }


    /**
     * Testeamos que el método elimina correctamente la foto indicada por parámetro
     *
     * @return void
     * @group deletePhoto
     */
    public function testDeletPhoto(){
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        $p1->setUrl('url/photo1');
        $p1->setMain(1);

        $p2->setUrl('url/photo2');
        $p2->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Elche');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(50);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        $accom=$am->createAccom($a1, $um->getID($owner->getEmail()));
        $this->SeeInDatabase('accommodations', ['title' => 'Casa rural']);
        $photos = $am->allPhotos($accom['id']);
        $photo = $photos[0];
        $this->assertTrue($am->deletePhoto($photo->getID()));
        $this->notSeeInDatabase('photos', ['url' => 'url/photo1']);
        $this->seeInDatabase('photos', ['url' => 'url/photo2']);
    }


    /**
     * Testeamos que el método NO elimine correctamente una foto de la base de datos
     *
     * @return void
     * @group deletePhotoFail
     */
    public function testDeletePhotoFail(){
        $am = new AccommodationModel();

        $result = $am->deletePhoto(250);

        $this->assertFalse($result);

    }

}
