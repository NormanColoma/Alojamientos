<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 19/08/2015
 * Time: 20:26
 */

use App\Models\DTO\Owner;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccommAcceptanceTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test para visitar la página de alojamientos.
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function see_accomm_page(){

        $um = new UserModel();
        $owner = new Owner();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("123456");

        $um->createUser($owner);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/owner');

        $this->visit('manage/owner#accoms')->see('Alojamientos');

    }

    /**
     * Test para visitar la página de añadir alojamientos.
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function see_newAccomm_page(){

        $um = new UserModel();
        $owner = new Owner();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("123456");

        $um->createUser($owner);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/owner');

        $this->visit('manage/owner#newAccom')->see('Nuevo Alojamiento');

    }

    /**
     * Test para visitar la página de añadir alojamientos e insertar uno.
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function try_newAccom_valid(){

        $um = new UserModel();
        $owner = new Owner();

        $owner->setName("Norman");
        $owner->setEmail("norman@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("654987321");
        $owner->setPassword("123456");

        $um->createUser($owner);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/owner');

        $this->visit('manage/owner#newAccom')->see('Nuevo Alojamiento')
            ->type('', 'new-accom-title')->type('', 'new-accom-city')->type('', 'new-accom-province')
            ->type('', 'new-accom-price')->type('', 'new-accom-beds')->type('', 'new-accom-baths')
            ->type('', 'new-accom-capacity')->type('', 'new-accom-inside')->type('', 'new-accom-outside')
            ->type('', 'new-accom-desc')->type('', 'new-accom-main-img')->type('', '')
            ->press('btn-register')
            ->seePageIs('/manage/traveler');

    }

}
