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
    


}
