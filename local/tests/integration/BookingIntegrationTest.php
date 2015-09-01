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
        $b->setDate('29-11-2015');

        $book = $bm->createBooking($b, $um->getID($traveler->getEmail()), $accom['id']);

        $this->SeeInDatabase('bookings', ['persons' => 3]);
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

        $b->setId(1);
        $b->setPersons(3);
        $b->setPrice(24.00);
        $b->setPreBooking(false);
        $b->setDate('29-11-2015');

        $book = $bm->createBooking($b, $um->getID($traveler->getEmail()), $accom['id']);

        $this->SeeInDatabase('bookings', ['persons' => 3]);

        $bm->deleteBooking($book['id']);

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
        $b->setDate('29-11-2015');

        $b2->setId(1);
        $b2->setPersons(5);
        $b2->setPrice(28.00);
        $b2->setPreBooking(false);
        $b2->setDate('30-11-2015');

        $book = $bm->createBooking($b, $um->getID($traveler->getEmail()), $accom['id']);

        $this->SeeInDatabase('bookings', ['persons' => 3]);

        $bm->updateBooking($b2, $book['id']);

        $this->notSeeInDatabase('bookings', ['persons' => 3]);
        $this->SeeInDatabase('bookings', ['persons' => 5]);
    }

}
