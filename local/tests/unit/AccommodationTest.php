<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 18/08/2015
 * Time: 20:28
 */

use App\Models\DTO\Accommodation;
use App\Models\DTO\Photo;

class AccommodationTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     * @group accomm
     */
    public function testAccommodation(){

        $accomm = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $arrayPhoto = [];
        $arrayPhoto2 = [];

        $p1->setUrl('url/photo1');
        $p1->setMain(0);

        $p2->setUrl('url/photo2');
        $p2->setMain(1);

        $arrayPhoto [] = $p1;
        $arrayPhoto [] = $p2;

        $arrayPhoto2 [] = $p1;
        $arrayPhoto2 [] = $p2;

        $this->assertEquals('El propietario aún no ha detallado nada sobre las características interiores del alojamiento.', $accomm->getInside());
        $this->assertEquals('El propietario aún no ha detallado nada sobre las características exteriores del alojamiento.', $accomm->getOutside());

        $accomm->setBaths(2);
        $accomm->setBeds(3);
        $accomm->setCapacity(5);
        $accomm->setCity('Elche');
        $accomm->setDesc('Alojamiento de lujo.');
        $accomm->setInside('Descripción del interior del alojamiento.');
        $accomm->setOutside('Descripción del exterior del alojamiento.');
        $accomm->setPhotos($arrayPhoto);
        $accomm->setPrice(50);
        $accomm->setProvince('Alicante');
        $accomm->setTitle('Casa rural');

        $this->assertEquals(2, $accomm->getBaths());
        $this->assertEquals(3, $accomm->getBeds());
        $this->assertEquals(5, $accomm->getCapacity());
        $this->assertEquals('Elche', $accomm->getCity());
        $this->assertEquals('Alojamiento de lujo.', $accomm->getDesc());
        $this->assertEquals('Descripción del interior del alojamiento.', $accomm->getInside());
        $this->assertEquals('Descripción del exterior del alojamiento.', $accomm->getOutside());
        $this->assertEquals(50, $accomm->getPrice());
        $this->assertEquals('Alicante', $accomm->getProvince());
        $this->assertEquals('Casa rural', $accomm->getTitle());
        $this->assertEquals($arrayPhoto2, $accomm->getPhotos());

    }

    /**
     * Testeamos el método setInitialDesc, que nos fija el texto de la descripción
     * a un tamaño de cadena de 337 caracteres (acorde con el diseño).
     *
     * @return void
     * @group accomm
     */
    public function testInitialDesc(){
        $accomm = new Accommodation();
        $accomm->setDesc("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.");
        $accomm->setInitialDesc($accomm->getDesc());
        $this->assertEquals(337,strlen($accomm->getInitialDesc()));
        $this->assertEquals($accomm->getInitialDesc(),"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur....");
    }
    


}
