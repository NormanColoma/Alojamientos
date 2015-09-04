<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 22/08/2015
 * Time: 11:42
 */

use App\Models\AccommodationModel;
use App\Models\DTO\Message;
use App\Models\DTO\Schedule;
use App\Models\DTO\Traveler;
use App\Models\SystemModel;
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

    public function testGetAccomsByDate3(){
        $sm = new \App\Models\SystemModel();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $a2 = new Accommodation();
        $a3 = new Accommodation();
        $a4 = new Accommodation();
        $a5 = new Accommodation();
        $a6 = new Accommodation();
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

        $a2->setBaths(2);
        $a2->setBeds(3);
        $a2->setCapacity(5);
        $a2->setCity('Elche');
        $a2->setDesc('Alojamiento de lujo 2.');
        $a2->setInside('Descripción del interior del alojamiento 2.');
        $a2->setOutside('Descripción del exterior del alojamiento 2.');
        $a2->setPhotos($arrayPhoto);
        $a2->setPrice(75);
        $a2->setProvince('Alicante');
        $a2->setTitle('Casa rural 2');

        $a3->setBaths(2);
        $a3->setBeds(3);
        $a3->setCapacity(5);
        $a3->setCity('Elche');
        $a3->setDesc('Alojamiento de lujo 3.');
        $a3->setInside('Descripción del interior del alojamiento 3.');
        $a3->setOutside('Descripción del exterior del alojamiento 3.');
        $a3->setPhotos($arrayPhoto);
        $a3->setPrice(90);
        $a3->setProvince('Alicante');
        $a3->setTitle('Casa rural 3');

        $a4->setBaths(2);
        $a4->setBeds(3);
        $a4->setCapacity(5);
        $a4->setCity('Madrid');
        $a4->setDesc('Alojamiento de lujo 4.');
        $a4->setInside('Descripción del interior del alojamiento 4.');
        $a4->setOutside('Descripción del exterior del alojamiento 4.');
        $a4->setPhotos($arrayPhoto);
        $a4->setPrice(30);
        $a4->setProvince('Madrid');
        $a4->setTitle('Casa rural 4');

        $a5->setBaths(2);
        $a5->setBeds(3);
        $a5->setCapacity(5);
        $a5->setCity('Madrid');
        $a5->setDesc('Alojamiento de lujo 5.');
        $a5->setInside('Descripción del interior del alojamiento 5.');
        $a5->setOutside('Descripción del exterior del alojamiento 5.');
        $a5->setPhotos($arrayPhoto);
        $a5->setPrice(20);
        $a5->setProvince('Madrid');
        $a5->setTitle('Casa rural 5');

        $a6->setBaths(2);
        $a6->setBeds(3);
        $a6->setCapacity(5);
        $a6->setCity('Alicante');
        $a6->setDesc('Alojamiento de lujo 6.');
        $a6->setInside('Descripción del interior del alojamiento 6.');
        $a6->setOutside('Descripción del exterior del alojamiento 6.');
        $a6->setPhotos($arrayPhoto);
        $a6->setPrice(89);
        $a6->setProvince('Alicante');
        $a6->setTitle('Casa rural');

        $schedule = new Schedule();

        $accom= $am->createAccom($a1, $um->getID($owner->getEmail()));
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom['id'],$schedule);

        $accom2= $am->createAccom($a2, $um->getID($owner->getEmail()));
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom2['id'],$schedule);

        $accom3= $am->createAccom($a3, $um->getID($owner->getEmail()));
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom3['id'],$schedule);

        $accom4= $am->createAccom($a4, $um->getID($owner->getEmail()));
        $schedule->setDays("9/14/2015,9/15/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom4['id'],$schedule);

        $accom5= $am->createAccom($a5, $um->getID($owner->getEmail()));
        $schedule->setDays("9/14/2015,9/15/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom5['id'],$schedule);

        $accom6= $am->createAccom($a6, $um->getID($owner->getEmail()));
        $schedule->setDays("11/20/2015,11/21/2015,11/22/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom6['id'],$schedule);

        $accoms1 = $sm->allAccomByDates("Elche", "2015-10-14", "2015-10-16");
        $this->assertNull($accoms1);

        $accoms2 = $sm->allAccomByDates("Elche", "2015-10-17", "2015-10-18");
        $this->assertNotNull($accoms2);
        $this->assertEquals(3,count($accoms2));

        $accoms3 = $sm->allAccomByDates("Madrid", "2015-9-16", "2015-9-18");
        $this->assertNotNull($accoms3);
        $this->assertEquals(2,count($accoms3));
    }

    public function testAddMessage(){
        $owner = new Owner();
        $traveler = new Traveler();
        $um = new UserModel();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $traveler->setName("Pepe");
        $traveler->setEmail("pepe@email.com");
        $traveler->setSurname("Gómez");
        $traveler->setPhone("654983322");
        $traveler->setPassword("prueba2");

        $um->createUser($owner);
        $um->createUser($traveler);

        $message  = new Message();

        $message->setFrom($owner->getEmail());
        $message->setTo($traveler->getEmail());
        $message->setSubject("Probando");
        $message->setText("Esto es un mensaje de prueba");

        $sm = new SystemModel();

        $this->assertNotNull($sm->addMessage($message, $um->getID($owner->getEmail())));
        $this->assertNotNull($sm->addMessage($message, $um->getID($traveler->getEmail())));

        $this->SeeInDatabase('messages', ['from' => $owner->getEmail(), 'to' => $traveler->getEmail(), 'user_id' => $um->getID($owner->getEmail())]);
        $this->SeeInDatabase('messages', ['from' => $owner->getEmail(), 'to' => $traveler->getEmail(), 'user_id' => $um->getID($traveler->getEmail())]);
    }


    public function testGetMessages(){
        $owner = new Owner();
        $traveler = new Traveler();
        $um = new UserModel();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $traveler->setName("Pepe");
        $traveler->setEmail("pepe@email.com");
        $traveler->setSurname("Gómez");
        $traveler->setPhone("654983322");
        $traveler->setPassword("prueba2");

        $um->createUser($owner);
        $um->createUser($traveler);

        $message  = new Message();

        $message->setFrom($owner->getEmail());
        $message->setTo($traveler->getEmail());
        $message->setSubject("Probando");
        $message->setText("Esto es un mensaje de prueba");

        $sm = new SystemModel();

        $id1=$sm->addMessage($message, $um->getID($traveler->getEmail()));

        $message->setFrom($owner->getEmail());
        $message->setTo($traveler->getEmail());
        $message->setSubject("Segunda prueba");
        $message->setText("Esto es un mensaje de prueba por segunda vez");

        $id2=$sm->addMessage($message, $um->getID($traveler->getEmail()));

        $message->setFrom($traveler->getEmail());
        $message->setTo($owner->getEmail());
        $message->setSubject("Mensaje enviado");
        $message->setText("Esto es un mensaje enviado");
        $sm->addMessage($message, $um->getID($traveler->getEmail()));
        //Mensajes de entrada
        $messages = $sm->allIncomingMessages($traveler->getEmail());

        $this->assertEquals(2,count($messages));
        $this->assertEquals("Probando",$messages[0]->getSubject());
        $this->assertEquals("Segunda prueba",$messages[1]->getSubject());


        //Mensajes de salida
        $messages = $sm->allOutcomingMessages($traveler->getEmail());
        $this->assertEquals(1,count($messages));
        $this->assertEquals("Mensaje enviado",$messages[0]->getSubject());
        $this->assertEquals("Esto es un mensaje enviado",$messages[0]->getText());


    }


    public function testGetSingleMessage(){
        $owner = new Owner();
        $traveler = new Traveler();
        $um = new UserModel();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $traveler->setName("Pepe");
        $traveler->setEmail("pepe@email.com");
        $traveler->setSurname("Gómez");
        $traveler->setPhone("654983322");
        $traveler->setPassword("prueba2");

        $um->createUser($owner);
        $um->createUser($traveler);

        $message  = new Message();

        $message->setFrom($owner->getEmail());
        $message->setTo($traveler->getEmail());
        $message->setSubject("Probando");
        $message->setText("Esto es un mensaje de prueba");

        $sm = new SystemModel();

        $id=$sm->addMessage($message, $um->getID($traveler->getEmail()));

        $m = $sm->getMessage($id);

        $this->assertEquals("Probando",$m->getSubject());
        $this->assertEquals(false, $m->isRead());


    }


    public function testReadMessage(){
        $owner = new Owner();
        $traveler = new Traveler();
        $um = new UserModel();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $traveler->setName("Pepe");
        $traveler->setEmail("pepe@email.com");
        $traveler->setSurname("Gómez");
        $traveler->setPhone("654983322");
        $traveler->setPassword("prueba2");

        $um->createUser($owner);
        $um->createUser($traveler);

        $message  = new Message();

        $message->setFrom($owner->getEmail());
        $message->setTo($traveler->getEmail());
        $message->setSubject("Probando");
        $message->setText("Esto es un mensaje de prueba");

        $sm = new SystemModel();

        $id=$sm->addMessage($message, $um->getID($traveler->getEmail()));
        $m = $sm->getMessage($id);
        $this->assertEquals(false,$m->isRead());
        $this->assertEquals(true,$sm->readMessage($id));
        $m = $sm->getMessage($id);
        $this->assertEquals(true,$m->isRead());


    }


    public function testDeleteMessage(){
        $owner = new Owner();
        $traveler = new Traveler();
        $um = new UserModel();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("prueba");

        $traveler->setName("Pepe");
        $traveler->setEmail("pepe@email.com");
        $traveler->setSurname("Gómez");
        $traveler->setPhone("654983322");
        $traveler->setPassword("prueba2");

        $um->createUser($owner);
        $um->createUser($traveler);

        $message  = new Message();

        $message->setFrom($owner->getEmail());
        $message->setTo($traveler->getEmail());
        $message->setSubject("Probando");
        $message->setText("Esto es un mensaje de prueba");

        $sm = new SystemModel();

        $id=$sm->addMessage($message, $um->getID($traveler->getEmail()));
        $this->assertNotNull($sm->getMessage($id));
        $this->assertEquals(true, $sm->deleteMessage($id));
        $this->assertNull($sm->getMessage($id));



    }
}
