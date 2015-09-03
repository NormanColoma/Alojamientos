<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 01/09/2015
 * Time: 19:32
 */

use App\Models\UserModel;
use App\Models\AccommodationModel;
use App\Models\BookingModel;
use App\Models\DTO\Booking;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Traveler;
use App\Models\DTO\Photo;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookingIntegrationTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Insertamos una reserva en la base de datos
     *
     * @return void
     * @group insertBook
     */
    public function testInsertBooking(){
        $bm = new BookingModel();
        $b = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book);
    }

    /**
     * Insertamos una reserva en la base de datos con fecha ya existente
     *
     * @return void
     * @group insertBook
     */
    public function testInsertBooking2(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book);

        $b2->setId(2);
        $b2->setPersons(5);
        $b2->setPrice(24.00);
        $b2->setPreBooking(false);
        $b2->setCheckIn('25-11-2015');
        $b2->setCheckOut('30-11-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setAccommId($accom['id']);

        $book2 = $bm->createBooking($b2);

        $this->NotSeeInDatabase('bookings', ['persons' => 5]);
        $this->assertNull($book2);


    }

    /**
     * Insertamos una reserva en la base de datos con fecha ya existente
     *
     * @return void
     * @group insertBook
     */
    public function testInsertBooking3(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book);

        $b2->setId(2);
        $b2->setPersons(5);
        $b2->setPrice(24.00);
        $b2->setPreBooking(false);
        $b2->setCheckIn('30-11-2015');
        $b2->setCheckOut('3-12-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setAccommId($accom['id']);

        $book2 = $bm->createBooking($b2);

        $this->NotSeeInDatabase('bookings', ['persons' => 5]);
        $this->assertNull($book2);


    }

    /**
     * Insertamos una reserva en la base de datos
     *
     * @return void
     * @group insertBook
     */
    public function testInsertBooking4(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book);

        $b2->setId(2);
        $b2->setPersons(5);
        $b2->setPrice(24.00);
        $b2->setPreBooking(false);
        $b2->setCheckIn('1-12-2015');
        $b2->setCheckOut('3-12-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setAccommId($accom['id']);

        $book2 = $bm->createBooking($b2);

        $this->SeeInDatabase('bookings', ['persons' => 5]);
        $this->assertNotNull($book2);


    }

    /**
     * Eliminamos una reserva en la base de datos
     *
     * @return void
     * @group deleteBook
     */
    public function testDeleteBooking(){
        $bm = new BookingModel();
        $b = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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

        $b->setPersons(3);
        $b->setPrice(24.00);
        $b->setPreBooking(false);
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book_id = $bm->createBooking($b, $um->getID($traveler->getEmail()), $accom['id']);

        $this->SeeInDatabase('bookings', ['persons' => 3]);

        $bm->deleteBooking($book_id);

        $this->notSeeInDatabase('bookings', ['persons' => 3]);
    }

    /**
     * Actualizamos una reserva en la base de datos
     *
     * @return void
     * @group updateBook
     */
    public function testUpdateBooking(){
        $bm = new BookingModel();
        $b = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book_id = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['total_price' => 24.00]);
        $this->assertNotNull($book_id);

        $b2 = new Booking();
        $b2->setPrice(28.00);

        $bm->updateBooking($b2, $book_id);

        $this->notSeeInDatabase('bookings', ['total_price' => 24.00]);
        $this->SeeInDatabase('bookings', ['total_price' => 28.00]);
    }

    /**
     * Mostramos una reserva
     *
     * @return void
     * @group showBook
     */
    public function testShowBooking()
    {
        $bm = new BookingModel();
        $b = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('11/25/2015');
        $b->setCheckOut('11/30/2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book_id = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book_id);

        $b2 = $bm->showBooking($book_id);

        $this->assertEquals($b->getPrice(), $b2->getPrice());
        $this->assertEquals($b->getPersons(), $b2->getPersons());
    }

    /**
     * Insertamos una pre-reserva en la base de datos
     *
     * @return void
     * @group insertPreBook
     */
    public function testInsertPreBooking(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book);

        $b2->setId(2);
        $b2->setPersons(5);
        $b2->setPrice(24.00);
        $b2->setPreBooking(true);
        $b2->setCheckIn('25-11-2015');
        $b2->setCheckOut('30-11-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setAccommId($accom['id']);

        $book2 = $bm->createBooking($b2);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->SeeInDatabase('bookings', ['persons' => 5]);
        $this->assertNotNull($book2);


    }

    /**
     * Insertamos una pre-reserva en la base de datos
     *
     * @return void
     * @group insertPreBook
     */
    public function testInsertPreBooking2(){
        $bm = new BookingModel();
        $b = new Booking();
        $b2 = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('30-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book);

        $b2->setId(2);
        $b2->setPersons(5);
        $b2->setPrice(24.00);
        $b2->setPreBooking(true);
        $b2->setCheckIn('25-11-2015');
        $b2->setCheckOut('30-11-2015');
        $b2->setUserId($um->getID($traveler->getEmail()));
        $b2->setAccommId($accom['id']);

        $book2 = $bm->createBooking($b2);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->SeeInDatabase('bookings', ['persons' => 5]);
        $this->assertNotNull($book2);


    }

    /**
     * Mostramos una pre-reserva
     *
     * @return void
     * @group showPreBook
     */
    public function testShowPreBooking()
    {
        $bm = new BookingModel();
        $b = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('11/25/2015');
        $b->setCheckOut('11/30/2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book_id = $bm->createBooking($b);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book_id);

        $b2 = $bm->showPreBooking($book_id);

        $this->assertEquals($b->getPrice(), $b2->getPrice());
        $this->assertEquals($b->getPersons(), $b2->getPersons());
        $this->assertEquals($b->getPreBooking(), $b2->getPreBooking());
    }

    /**
     * Confirmamos una pre-reserva
     *
     * @return void
     * @group confirmPreBook
     */
    public function testConfirmPreBooking(){
        $bm = new BookingModel();
        $b = new Booking();
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $traveler = new Traveler();
        $um = new UserModel();
        $arrayPhoto = [];

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("prueba");

        $um->createUser($traveler);

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
        $b->setCheckIn('25-11-2015');
        $b->setCheckOut('28-11-2015');
        $b->setUserId($um->getID($traveler->getEmail()));
        $b->setAccommId($accom['id']);

        $book = $bm->createBooking($b);

        $bm->confirm($book);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
        $this->assertNotNull($book);
        $this->SeeInDatabase('schedules', ['day' => '2015-11-25']);
        $this->SeeInDatabase('schedules', ['day' => '2015-11-26']);
        $this->SeeInDatabase('schedules', ['day' => '2015-11-27']);
        $this->SeeInDatabase('schedules', ['day' => '2015-11-28']);
    }

}
