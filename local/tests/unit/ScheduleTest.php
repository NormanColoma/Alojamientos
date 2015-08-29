<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 28/08/2015
 * Time: 19:25
 */

use App\Models\DTO\Schedule;

class ScheduleTest extends TestCase
{

    /**
     * Test getters y setters de la clase Schedule
     *
     * @return void
     * @group schedule
     */
    public function testSchedule(){
        $sc = new Schedule();

        $sc->setDays("Monday, Tuesday");
        $sc->setId(1);

        $this->assertEquals('Monday, Tuesday', $sc->getDays());
        $this->assertEquals(1, $sc->getId());

    }

}
