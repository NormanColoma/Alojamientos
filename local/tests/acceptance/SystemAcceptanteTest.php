<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 22/08/2015
 * Time: 13:14
 */

use App\Models\AccommodationModel;
use App\Models\UserModel;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;
use App\Models\DTO\Owner;
use App\Models\DTO\Schedule;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SystemAcceptanteTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Escenario: Buscar los alojamientos de una ciudad que no tiene ninguno desde índice
     * Dado que soy un usuario del sistema y pretendo buscar los alojamientos de una determinada ciudad desde el indice
     * Si escribo dicha ciudad en el buscador y no se encuentran resultados
     * El sistema deberá redireccionar a la dirección 'search/accommodations/City/page/1'
     * Y mostrar el siguiente mensaje 'No hay resultados para la búsqueda introducida!'
     *
     * @return void
     * @group searchAcceptance
     * @test
     */
    public function try_index_search_empty(){

        $this->visit('/')->see('Destacados')
            ->type('Elche', 'city')
            ->press('BUSCAR')
            ->seePageIs('search/accommodations/Elche/page/1')
            ->see('No hay resultados para la búsqueda introducida!');

    }

    /**
     * Escenario: Buscar los alojamientos sin especificar una ciudad desde índice
     * Dado que soy un usuario del sistema y pretendo buscar los alojamientos de una determinada ciudad desde el indice
     * Si dejo el campo Ciudad vacío
     * El sistema deberá mostrar el siguiente mensaje 'Introduce una ciudad'
     *
     * @return void
     * @group searchAcceptance
     * @test
     */
    public function try_index_search_city_empty(){

        $this->visit("/home")->see("Destacados")->type("","city")
            ->press("BUSCAR")->seePageIs("/search/accommodations")->see("No hay resultados para la búsqueda introducida!");

    }

    /**
     * Escenario: Buscar los alojamientos de una ciudad de la que se disponen alojamientos desde íncide
     * Dado que soy un usuario del sistema y pretendo buscar los alojamientos de una determinada ciudad desde el indice
     * Si escribo dicha ciudad en el buscador y sí que hay resultadops
     * El sistema deberá redireccionar a la dirección 'search/accommodations/City/page/1'
     * Y mostrar los alojamientos disponibles
     *
     * @return void
     * @group searchAcceptance
     * @test
     */
    public function try_index_search(){

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
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

        $am->createAccom($a1, $um->getID($owner->getEmail()));

        $this->visit('/')->see('Destacados')
            ->type('Elche', 'city')
            ->press('BUSCAR')
            ->seePageIs('search/accommodations/Elche/page/1')
            ->see('Elche');

    }

    /**
     * Escenario: Buscar los alojamientos de una ciudad que no tiene ninguno o campo vacío desde página de búsqueda
     * Dado que soy un usuario del sistema y pretendo buscar los alojamientos de una determinada ciudad desde la página de búsqueda
     * Si escribo dicha ciudad en el buscador y no se encuentran resultados o dejo el campo ciudad vacío
     * El sistema deberá redireccionar a la dirección 'search/accommodations/City/page/1' o a 'search/accommodations/', respectivamente
     * Y mostrar el siguiente mensaje 'No hay resultados para la búsqueda introducida!'
     *
     * @return void
     * @group searchAcceptance
     * @test
     */
    public function try_search_empty(){

        $this->visit('/')->see('Destacados')
            ->type('Elche', 'city')
            ->press('BUSCAR')
            ->seePageIs('search/accommodations/Elche/page/1')
            ->see('No hay resultados para la búsqueda introducida!')
            ->press('Buscar')
            ->seePageIs('/search/accommodations')
            ->see('No hay resultados para la búsqueda introducida!')
            ->type('Madrid', 'city')
            ->press('Buscar')
            ->seePageIs('/search/accommodations/Madrid/page/1')
            ->see('No hay resultados para la búsqueda introducida!');

    }

    /**
     * Escenario: Buscar los alojamientos de una ciudad que sí tiene resultados desde página de búsqueda
     * Dado que soy un usuario del sistema y pretendo buscar los alojamientos de una determinada ciudad desde la página de búsqueda
     * Si escribo dicha ciudad en el buscador y sí se encuentran resultados
     * El sistema deberá redireccionar a la dirección 'search/accommodations/City/page/1'
     * Y mostrar los alojamientos disponibles
     *
     * @return void
     * @group searchAcceptance
     * @test
     */
    public function try_search(){

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
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

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $a1->setBaths(2);
        $a1->setBeds(3);
        $a1->setCapacity(5);
        $a1->setCity('Madrid');
        $a1->setDesc('Alojamiento de lujo.');
        $a1->setInside('Descripción del interior del alojamiento.');
        $a1->setOutside('Descripción del exterior del alojamiento.');
        $a1->setPhotos($arrayPhoto);
        $a1->setPrice(50);
        $a1->setProvince('Madrid');
        $a1->setTitle('Casa rural');

        $am->createAccom($a1, $um->getID($owner->getEmail()));

        $this->visit('/')->see('Destacados')
            ->type('Elche', 'city')
            ->press('BUSCAR')
            ->seePageIs('search/accommodations/Elche/page/1')
            ->see('No hay resultados para la búsqueda introducida!')
            ->type('Madrid', 'city')
            ->press('Buscar')
            ->seePageIs('/search/accommodations/Madrid/page/1')
            ->see('Madrid');

    }

    /**
     * Escenario: Buscar los alojamientos de una ciudad en una determinada fecha de la que se disponen alojamientos desde íncide
     * Dado que soy un usuario del sistema y pretendo buscar los alojamientos de una determinada ciudad desde el indice
     * Si escribo dicha ciudad en el buscador y las fechas que deseo y sí que hay resultados
     * El sistema deberá redireccionar a la dirección 'search/accommodations/Elche/checkIn/2015-12-08/checkOut/2015-12-10/page/1'
     * Y mostrar los alojamientos disponibles
     *
     * @return void
     * @group searchAcceptance
     * @test
     */
    public function try_index_search_by_date(){

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
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

        $am->createAccom($a1, $um->getID($owner->getEmail()));

        $accom= $am->createAccom($a1, $um->getID($owner->getEmail()));
        $schedule = new Schedule();
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom['id'],$schedule);

        $this->visit('/')->see('Destacados')
            ->type('Elche', 'city')
            ->type('12/08/2015', 'check-in')
            ->type('12/10/2015', 'check-out')
            ->press('BUSCAR')
            ->seePageIs('search/accommodations/Elche/checkIn/2015-12-08/checkOut/2015-12-10/page/1')
            ->see('Elche');

    }

    /**
     * Escenario: Buscar los alojamientos de una ciudad en una determinada fecha de la que se disponen alojamientos desde íncide
     * Dado que soy un usuario del sistema y pretendo buscar los alojamientos de una determinada ciudad desde el indice
     * Si escribo dicha ciudad en el buscador y las fechas que deseo y no hay resultados
     * El sistema deberá redireccionar a la dirección 'search/accommodations/Elche/checkIn/2015-10-14/checkOut/2015-10-16/page/1'
     * Y no mostrar alojamientos
     *
     * @return void
     * @group searchAcceptance
     * @test
     */
    public function try_index_search_by_date2(){

        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
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

        $am->createAccom($a1, $um->getID($owner->getEmail()));

        $accom= $am->createAccom($a1, $um->getID($owner->getEmail()));
        $schedule = new Schedule();
        $schedule->setDays("10/14/2015,10/15/2015,10/16/2015");
        $schedule->format_calendar();
        $am->addSchedule($accom['id'],$schedule);

        $this->visit('/')->see('Destacados')
            ->type('Elche', 'city')
            ->type('10/14/2015', 'check-in')
            ->type('10/16/2015', 'check-out')
            ->press('BUSCAR')
            ->seePageIs('search/accommodations/Elche/checkIn/2015-10-14/checkOut/2015-10-16/page/1');

    }
}
