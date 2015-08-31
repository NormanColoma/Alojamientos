<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 22/08/2015
 * Time: 11:42
 */

use App\Models\AccommodationModel;
use App\Models\DTO\Schedule;
use App\Models\UserModel;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;
use App\Models\DTO\Owner;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SystemIntegrationTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Recuperamos los alojamientos de una determinada ciudad de la BD
     *
     * @return void
     * @group getAccomByCity
     */
    public function testgetAllAccommByCity(){

        $this->notSeeInDatabase('accommodations', ['title' => 'Casa rural']);

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $a2 = new Accommodation();
        $p1 = new Photo();
        $p3 = new Photo();
        $p2 = new Photo();
        $p4 = new Photo();
        $owner = new Owner();
        $owner2 = new Owner();
        $um = new UserModel();
        $sm = new \App\Models\SystemModel();
        $arrayPhoto = [];
        $arrayPhoto2 = [];
        $arrayAcomm = [];

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $owner2->setName("Norman");
        $owner2->setEmail("norman@email.com");
        $owner2->setSurname("Coloma");
        $owner2->setPhone("654987321");
        $owner2->setPassword("prueba");

        $um->createUser($owner);
        $um->createUser($owner2);

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

        $a2->setBaths(4);
        $a2->setBeds(5);
        $a2->setCapacity(20);
        $a2->setCity('Elche');
        $a2->setDesc('Alojamiento de caca.');
        $a2->setInside('Descripción del interior del alojamiento2.');
        $a2->setOutside('Descripción del exterior del alojamiento2.');
        $a2->setPhotos($arrayPhoto2);
        $a2->setPrice(number_format((float)150, 2, '.', ''));
        $a2->setProvince('Alicante');
        $a2->setTitle('Casa rural2');
        $a2->setInitialDesc($a2->getDesc());

        $accom = $am->createAccom($a1, $um->getID($owner->getEmail()));
        $accom2 = $am->createAccom($a2, $um->getID($owner2->getEmail()));

        $a1->setID($accom['id']);
        $a2->setID($accom2['id']);
        $a1->setPhotos($am->allPhotos($accom['id']));
        $a2->setPhotos($am->allPhotos($accom2['id']));
        $arrayAcomm [] = $a1;
        $arrayAcomm [] = $a2;

        $this->SeeInDatabase('accommodations', ['title' => 'Casa rural']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo1']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo2']);
        $this->SeeInDatabase('accommodations', ['title' => 'Casa rural2']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo3']);
        $this->SeeInDatabase('photos', ['url' => 'url/photo4']);

        //Testeamos el método allAccomByCity
        $this->assertEquals($arrayAcomm, $sm->allAcomByCity("Elche"));

    }

    /**
     * Recuperamos los alojamientos de una ciudad de la que no hay ninguno de la BD
     *
     * @return void
     * @group getAccomByCity
     */
    public function testgetAllAccommByCityEmpty(){

        $sm = new \App\Models\SystemModel();

        //Testeamos el método allAccomByCity
        $this->assertEquals(null, $sm->allAcomByCity("Elche"));

    }



    public function testGetAccomsIDByDate()
    {
        $sm = new \App\Models\SystemModel();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $p3 = new Photo();
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
        $p3->setUrl('url/photo3');
        $p3->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;
        $arrayPhoto [] = $p3;


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
        $schedule = new Schedule();
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom['id'], $schedule);
        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('San Vicente');
        $a1->setDesc('Alojamiento en San Vicnete.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(150);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural en San Vicente');
        $accom2 =  $am->createAccom($a1, $um->getID($owner->getEmail()));
        $schedule = new Schedule();
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom2['id'], $schedule);
        $ids = $sm->accommodationsForDates("2015-10-14","2015-10-15");
        $this->assertEquals(2,count($ids));
        $this->assertEquals($ids[0],$accom['id']);
        $this->assertEquals($ids[1],$accom2['id']);
    }

    public function testGetAccomsIDByDate2()
    {
        $sm = new \App\Models\SystemModel();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $p3 = new Photo();
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
        $p3->setUrl('url/photo3');
        $p3->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;
        $arrayPhoto [] = $p3;


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
        $schedule = new Schedule();
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom['id'], $schedule);
        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('San Vicente');
        $a1->setDesc('Alojamiento en San Vicnete.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(150);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural en San Vicente');
        $accom2 =  $am->createAccom($a1, $um->getID($owner->getEmail()));
        $ids = $sm->accommodationsForDates("2015-10-14","2015-10-15");
        $this->assertEquals(1,count($ids));
        $this->assertEquals($ids[0],$accom['id']);
    }

    public function testGetAccomsIDByDate3()
    {
        $sm = new \App\Models\SystemModel();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $p3 = new Photo();
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
        $p3->setUrl('url/photo3');
        $p3->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;
        $arrayPhoto [] = $p3;


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
        $schedule = new Schedule();
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom['id'], $schedule);
        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('San Vicente');
        $a1->setDesc('Alojamiento en San Vicnete.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(150);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural en San Vicente');
        $accom2 =  $am->createAccom($a1, $um->getID($owner->getEmail()));
        $schedule = new Schedule();
        $schedule->setDays("10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom2['id'], $schedule);
        $ids = $sm->accommodationsForDates("2015-10-14","2015-10-16");
        $this->assertEquals(2,count($ids));
        $this->assertEquals($ids[0],$accom['id']);
        $this->assertEquals($ids[1],$accom2['id']);
    }

    public function testGetAccomsByDate(){
        $sm = new \App\Models\SystemModel();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $p3 = new Photo();
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
        $p3->setUrl('url/photo3');
        $p3->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;
        $arrayPhoto [] = $p3;


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

        $accom= $am->createAccom($a1, $um->getID($owner->getEmail()));
        $schedule = new Schedule();
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom['id'],$schedule);
        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('San Vicente');
        $a1->setDesc('Alojamiento en San Vicnete.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(150);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural en San Vicente');
        $am->createAccom($a1, $um->getID($owner->getEmail()));
        $accoms = $sm->allAccomByDates("Alicante", "2015-10-14", "2015-10-16");
        $this->assertNotNull($accoms);
        $this->assertEquals(1,count($accoms));
        $this->assertEquals('Casa rural en San Vicente', $accoms[0]->getTitle());
    }

    public function testGetAccomsByDate2(){
        $sm = new \App\Models\SystemModel();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $p3 = new Photo();
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
        $p3->setUrl('url/photo3');
        $p3->setMain(0);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;
        $arrayPhoto [] = $p3;


        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Alicante');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(50);
        $a1->setProvince('Alicante');
        $a1->setTitle('Casa rural');

        $am->createAccom($a1, $um->getID($owner->getEmail()));
        $accoms = $sm->allAccomByDates("Alicante", "2015-10-14", "2015-10-16");
        $this->assertNotNull($accoms);
        $this->assertEquals(1,count($accoms));
        $this->assertEquals('Casa rural', $accoms[0]->getTitle());
    }
}
