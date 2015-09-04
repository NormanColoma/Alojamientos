<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 15/08/2015
 * Time: 20:13
 */

use App\Models\DTO\Traveler;
use App\Models\DTO\Admin;
use App\Models\DTO\Owner;
use App\Models\UserModel;
use App\Models\AccommodationModel;
use App\Models\BookingModel;
use App\Models\DTO\Booking;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserIntegrationTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Insertamos un usuario en la base de datos
     *
     * @return void
     * @group insert
     */
    public function testInsertUser(){

        $this->notSeeInDatabase('users', ['email' => 'javier@email.com']);

        $userModel = new UserModel();
        $traveler = new Traveler();

        $traveler->setEmail('javier@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('Javier');
        $traveler->setOwner(false);
        $traveler->setPhone('654321987');
        $traveler->setSurname('Comino');

        $userModel->createUser($traveler);

        $this->seeInDatabase('users', ['email' => 'javier@email.com']);

        $traveler2 = new Traveler();

        $traveler2->setEmail('javier@email.com');
        $traveler2->setAdmin(false);
        $traveler2->setPassword('123456');
        $traveler2->setName('Javi Missed');
        $traveler2->setOwner(false);
        $traveler2->setPhone('654321987');
        $traveler2->setSurname('Vera');

        $userModel->createUser($traveler2);

        $this->notSeeInDatabase('users', ['name' => 'Javi Missed']);

    }

    /**
     * Actualizamos un usuario en la base de datos
     *
     * @return void
     * @group updateUser
     */
    public function testUpdateUser(){


        $userModel = new UserModel();
        $traveler = new Traveler();

        $traveler->setEmail('prueba@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('NombrePrueba');
        $traveler->setOwner(false);
        $traveler->setPhone('156879654');
        $traveler->setSurname('ApellidoPrueba');

        $user = $userModel->createUser($traveler);

        $this->seeInDatabase('users', ['email' => 'prueba@email.com']);

        $traveler2 = new Traveler();

        $traveler2->setEmail('missed@email.com');
        $traveler2->setAdmin(false);
        $traveler2->setPassword('123456');
        $traveler2->setName('Javi Missed');
        $traveler2->setOwner(false);
        $traveler2->setPhone('654321987');
        $traveler2->setSurname('Vera');

        $this->assertTrue($userModel->updateUser($user['id'], $traveler2));

        $this->SeeInDatabase('users', ['name' => 'Javi Missed']);

    }

    /**
     * Recuperamos todas las reservas de un usuario
     *
     * @return void
     * @group allBook
     */
    public function testAllBookings(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $b3 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");


        $owner->setName("Juan");
        $owner->setEmail("paco@email.com");
        $owner->setSurname("Cano");
        $owner->setPhone("654987325");
        $owner->setPassword("prueba2");

        $um->createUser($traveler);
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
        $accom = $am->createAccom($a1, $um->getID($traveler->getEmail()));

        $b->setId(1);
        $b->setPersons(3);
        $b->setPrice(24.00);
        $b->setPreBooking(false);
        $b->setCheckIn('25-10-2015');
        $b->setCheckOut('30-10-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setOwnerId($um->getID($owner->getEmail()));
        $b->setAccommId($accom['id']);

        $b2->setId(2);
        $b2->setPersons(6);
        $b2->setPrice(45.00);
        $b2->setPreBooking(false);
        $b2->setCheckIn('25-11-2015');
        $b2->setCheckOut('30-11-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setOwnerId($um->getID($owner->getEmail()));
        $b2->setAccommId($accom['id']);

        $b3->setId(3);
        $b3->setPersons(7);
        $b3->setPrice(29.00);
        $b3->setPreBooking(false);
        $b3->setCheckIn('25-12-2015');
        $b3->setCheckOut('30-12-2015');
        $b3->setUserId($um->getID($traveler->getEmail()));
        $b3->setOwnerId($um->getID($owner->getEmail()));
        $b3->setAccommId($accom['id']);

        $book = $bm->createBooking($b);
        $bm->createBooking($b2);
        $bm->createBooking($b3);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->SeeInDatabase('bookings', ['persons' => 6]);
        $this->SeeInDatabase('bookings', ['persons' => 7]);
        $this->assertNotNull($book);

        $this->assertEquals(3, count($um->allBookings($um->getID($traveler->getEmail()))));
    }

    /**
 * Recuperamos todas las pre-reservas de un usuario
 *
 * @return void
 * @group allPreBook
 */
    public function testAllPreBookings(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $owner->setName("Juan");
        $owner->setEmail("paco@email.com");
        $owner->setSurname("Cano");
        $owner->setPhone("654987325");
        $owner->setPassword("prueba2");

        $um->createUser($traveler);
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
        $accom = $am->createAccom($a1, $um->getID($traveler->getEmail()));

        $b->setId(1);
        $b->setPersons(3);
        $b->setPrice(24.00);
        $b->setPreBooking(true);
        $b->setCheckIn('25-10-2015');
        $b->setCheckOut('30-10-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setOwnerId($um->getID($owner->getEmail()));
        $b->setAccommId($accom['id']);

        $b2->setId(2);
        $b2->setPersons(6);
        $b2->setPrice(45.00);
        $b2->setPreBooking(true);
        $b2->setCheckIn('25-11-2015');
        $b2->setCheckOut('30-11-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setOwnerId($um->getID($owner->getEmail()));
        $b2->setAccommId($accom['id']);

        $book = $bm->createBooking($b);
        $bm->createBooking($b2);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->SeeInDatabase('bookings', ['persons' => 6]);
        $this->assertNotNull($book);

        $this->assertEquals(2, count($um->allPreBookings($um->getID($traveler->getEmail()))));
    }


    /**
     * Recuperamos todas las pre-reservas de un propietario
     *
     * @return void
     * @group allPreBook
     */
    public function testAllPreBookingsByOwner(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $owner->setName("Juan");
        $owner->setEmail("paco@email.com");
        $owner->setSurname("Cano");
        $owner->setPhone("654987325");
        $owner->setPassword("prueba2");

        $um->createUser($traveler);
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
        $accom = $am->createAccom($a1, $um->getID($traveler->getEmail()));

        $b->setId(1);
        $b->setPersons(3);
        $b->setPrice(24.00);
        $b->setPreBooking(true);
        $b->setCheckIn('25-10-2015');
        $b->setCheckOut('30-10-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setOwnerId($um->getID($owner->getEmail()));
        $b->setAccommId($accom['id']);

        $b2->setId(2);
        $b2->setPersons(6);
        $b2->setPrice(45.00);
        $b2->setPreBooking(true);
        $b2->setCheckIn('25-11-2015');
        $b2->setCheckOut('30-11-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setOwnerId($um->getID($owner->getEmail()));
        $b2->setAccommId($accom['id']);

        $book = $bm->createBooking($b);
        $bm->createBooking($b2);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->SeeInDatabase('bookings', ['persons' => 6]);
        $this->assertNotNull($book);

        $this->assertEquals(2, count($um->allPreBookingsByOwner($um->getID($owner->getEmail()))));
    }


    /**
     * Insertamos un usuario en la base de datos
     *
     * @return void
     * @group insert
     */
    public function testGetUserByID(){

        $this->notSeeInDatabase('users', ['email' => 'javier@email.com']);

        $userModel = new UserModel();
        $traveler = new Traveler();

        $traveler->setEmail('javier@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('Javier');
        $traveler->setOwner(false);
        $traveler->setPhone('654321987');
        $traveler->setSurname('Comino');

        $userModel->createUser($traveler);

        $this->seeInDatabase('users', ['email' => 'javier@email.com']);

        $traveler2 = new Owner();

        $traveler2->setEmail('norman@email.com');
        $traveler2->setAdmin(false);
        $traveler2->setPassword('123456');
        $traveler2->setName('Norman');
        $traveler2->setOwner(true);
        $traveler2->setPhone('654321987');
        $traveler2->setSurname('Coloma');

        $userModel->createUser($traveler2);

        $u1 = $userModel->userById($userModel->getID("javier@email.com"), "traveler");
        $this->assertEquals("javier@email.com",$u1->getEmail());

    }

}
