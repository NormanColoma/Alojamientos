<?php



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

    /**
     * Test getters y setters de la clase Schedule
     *
     * @return void
     * @group schedule
     */
    public function testFormatCalendar(){
        $sc = new Schedule();

        $sc->setDays("08/14/2015,08/19/2015,08/17/2015");
        $sc->format_calendar();
        $this->assertEquals(3,count($sc->getDays()));
        $this->assertEquals($sc->getDays()[0], "2015-08-14");
        $this->assertEquals($sc->getDays()[1], "2015-08-19");
        $this->assertEquals($sc->getDays()[2], "2015-08-17");
    }

}
