<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 01/09/2015
 * Time: 19:00
 */

use App\Models\DTO\Booking;
use App\Models\DTO\PreBooking;

class BookingTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     * @group prueba
     */
    public function testBooking(){
        $b = new Booking();

        $b->setId(1);
        $b->setPersons(13);
        $b->setPrice(123);
        $b->setPreBooking(false);
        $b->setDate('28-08-2015');

        $this->assertEquals(1, $b->getId());
        $this->assertEquals(13, $b->getPersons());
        $this->assertEquals(123, $b->getPrice());
        $this->assertEquals('2015-08-28', $b->getDate());
        $this->assertEquals(false, $b->getPreBooking());

    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group prueba
     */
    public function testBooking2(){
        $b = new Booking();

        $b->setId(1);
        $b->setPersons(0);
        $b->setPrice(24.00);
        $b->setPreBooking(true);
        $b->setDate('29-11-2015');

        $this->assertEquals(1, $b->getId());
        $this->assertEquals(0, $b->getPersons());
        $this->assertEquals(24.00, $b->getPrice());
        $this->assertEquals('2015-11-29', $b->getDate());
        $this->assertEquals(true, $b->getPreBooking());

    }

}
