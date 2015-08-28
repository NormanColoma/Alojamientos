<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 28/08/2015
 * Time: 19:32
 */

use App\Models\DTO\BookingDate;

class BookingDateTest extends TestCase
{

    /**
     * Test getters y setters de la clase BookingDate
     *
     * @return void
     * @group bookingDate
     */
    public function testBookingDate(){
        $bd = new BookingDate();

        $bd->setStarting('28-08-2015');
        $bd->setEnding('30-08-2015');

        $this->assertEquals('2015-08-28', $bd->getStarting());
        $this->assertEquals('2015-08-30', $bd->getEnding());

    }

}
