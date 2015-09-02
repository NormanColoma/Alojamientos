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
        $b->setUserId(3);
        $b->setAccommId(5);

        $this->assertEquals(1, $b->getId());
        $this->assertEquals(13, $b->getPersons());
        $this->assertEquals(123, $b->getPrice());
        $this->assertEquals(false, $b->getPreBooking());
        $this->assertEquals(3, $b->getUserId());
        $this->assertEquals(5, $b->getAccommId());

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
        $b->setUserId(8);
        $b->setAccommId(3);

        $this->assertEquals(1, $b->getId());
        $this->assertEquals(0, $b->getPersons());
        $this->assertEquals(24.00, $b->getPrice());
        $this->assertEquals(true, $b->getPreBooking());
        $this->assertEquals(8, $b->getUserId());
        $this->assertEquals(3, $b->getAccommId());

    }

}
