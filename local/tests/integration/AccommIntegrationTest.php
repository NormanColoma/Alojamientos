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
     *
     *
     * @return void
     * @group returnId
     */
    public function testReturnId(){

        $owner = new Owner();
        $um = new UserModel();
        $am = new AccommodationModel();
        $a1 = new Accommodation();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $um->createUser($owner);

        //$id = $um->getID($owner->getEmail());

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Elche');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPrice(50);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        $am->createAccom($a1, $um->getID($owner->getEmail()));

        $id = $am->getID($um->getID($owner->getEmail()));

        $this->assertNotNull($id);

    }

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
        $am->createAccom($a1, $um->getID($owner->getEmail()));

        $this->SeeInDatabase('accommodations', ['title' => 'Casa rural']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo1']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo2']);

        //Testeamos el método AllPhotos
        $this->assertEquals(2, count($am->allPhotos($am->getID($um->getID($owner->getEmail())))));

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

        $am->createAccom($a1, $um->getID($owner->getEmail()));

        $a1->setID($am->getID($um->getID($owner->getEmail())));

        $this->assertEquals($a1, $am->accommodationByID($am->getID($um->getID($owner->getEmail()))));
    }

}
