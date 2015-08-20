<?php
/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 20/08/2015
 * Time: 11:54
 */



use App\Models\DTO\Owner;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccommAcceptanceTest extends TestCase
{

    use DatabaseTransactions;


    /**
     * scenario: Alojamiento insertado correctamente por un Propietario
     * Dado que soy un Propietario
     * Y he insertado correctamente un alojamiento
     * Entonces desde el panel de control del Propietario se listará dicho alojamiento
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation(){
        $userModel = new UserModel();
        $owner = new Owner();
        $owner->setEmail('owner@email.com');
        $owner->setAdmin(false);
        $owner->setPassword('123456');
        $owner->setName('Owner');
        $owner->setOwner(true);
        $owner->setPhone('654321987');
        $owner->setSurname('Apellido');
        $userModel->createUser($owner);

        $this->visit('/login')
            ->type('owner@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('/manage/owner')->see("Alojamientos");
        $this->visit("/manage/owner#newAccom")->see("Nuevo Alojamiento")->type("Alojamiento", "new-accom-title")
            ->type("Alicante","new-accom-city")->type("Alicante", "new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->seePageIs("/manage/owner")->see("Alojamiento");



    }
}
