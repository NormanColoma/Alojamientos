<?php
/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 18/08/2015
 * Time: 19:57
 */

use App\Models\DTO\Photo;

class PhotoTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     * @group photo
     */
    public function testPhoto(){

        $photo = new Photo();

        $photo->setUrl('url/photos');
        $photo->setMain(0);

        $this->assertEquals('url/photos', $photo->getUrl());
        $this->assertEquals(0, $photo->getMain());

    }

}
