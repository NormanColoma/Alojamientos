<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 19/08/2015
 * Time: 20:26
 */

/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 20/08/2015
 * Time: 11:54
 */

use App\Models\AccommodationModel;
use App\Models\DTO\Accommodation;
use App\Models\DTO\Owner;
use App\Models\DTO\Photo;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccommAcceptanceTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Escenario: Visitar la página de alojamientos ingresados
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * El sistema debe dejarme acceder a la página manage/owner#accoms
     * Donde podré consultar los alojamientos que tengo añadidos en el sistema
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
     * Escenario: Visitar la página de añadir un alojamiento
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * El sistema debe dejarme acceder a la página 'manage/owner#newAccom
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
     * Escenario: Insertar un nuevo alojamiento
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y hago click en el botón 'Anunciar'
     * Entonces se debe insertar el anuncio y redireccionarme a la página donde aparecen mis alojamientos
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
            ->type("Alicante","new-accom-city")->select("Alicante", "new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->seePageIs("/manage/owner")->see("Alojamiento");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo título vacío
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y dejo vacío el campo título
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El campo es obligatorio"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_tittle_empty(){
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
        $this->visit("/manage/owner#newAccom")->see("Nuevo Alojamiento")->type("", "new-accom-title")
            ->type("Alicante","new-accom-city")->type("Alicante", "new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->see("El campo es obligatorio");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo ciudad vacío
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y dejo vacío el campo ciudad
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El campo es obligatorio"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_city_empty(){
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
            ->type("","new-accom-city")->type("Alicante", "new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->see("El campo es obligatorio");
    }


    /**
     * Escenario: Insertar un nuevo alojamiento campo precio vacío
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y dejo vacío el campo precio
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El campo es obligatorio"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_price_empty(){
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
            ->type("Alicante","new-accom-city")->type("Alicante", "new-accom-province")->type("","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->see("El campo es obligatorio");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo descripcion vacío
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y dejo vacío el campo descripcion
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El campo es obligatorio"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_desc_empty(){
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
            ->type("","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->see("El campo es obligatorio");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo imagen principal vacío
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y dejo vacío el campo imagen principal
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El campo es obligatorio"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_main_empty(){
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
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach("","new-accom-main-img")->press("Anunciar")
            ->see("El campo es obligatorio");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo título no válido
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y el campo título se rellena con números
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El formato introducido no es válido. Solo se permiten letras"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_tittle_invalid(){
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
        $this->visit("/manage/owner#newAccom")->see("Nuevo Alojamiento")->type("1", "new-accom-title")
            ->type("Alicante","new-accom-city")->type("Alicante", "new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->see("El formato introducido no es válido. Solo se permiten letras");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo ciudad no válido
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y el campo ciudad se rellena con números
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El formato introducido no es válido. Solo se permiten letras"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_city_invalid(){
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
            ->type("1","new-accom-city")->type("Alicante", "new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->see("El formato introducido no es válido. Solo se permiten letras");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo precio no válido
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y el campo precio se rellena con letras
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El formato introducido no es válido. Solo se permiten letras"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_price_invalid(){
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
            ->type("Alicante","new-accom-city")->type("Alicante", "new-accom-province")->type("precio","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/img1.jpg","new-accom-main-img")->press("Anunciar")
            ->see("El formato debe ser una cifra (para decimales usar punto. Ejemplo: 150.25)");
    }

    /**
     * Escenario: Insertar un nuevo alojamiento campo imagen principal no válido
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y el campo imagen principal no corresponde con una imagen en formato correcto
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El archivo debe ser una imagen (jpeg, png, bmp, gif, or jpg)"
     *
     * @return void
     * @group accommAcceptance2
     * @test
     */
    public function inserting_new_accommodation_main_invalid(){
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
            ->type("Alicante","new-accom-city")->select("Alicante","new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/falloFormato.txt","new-accom-main-img")->press("Anunciar")
            ->see("Nuevo Alojamiento");
    }


    /**
     * Escenario: Borrar un alojamiento
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando quiero borrar un alojamiento
     * Si hago click en el botón 'Eliminar'
     * Entonces debe eliminarse el alojamiento.
     *
     * @return void
     * @group accommAcceptance2
     * @test
     */
    public function deleting_accomodation(){
        $am = new AccommodationModel();
        $a1 = new Accommodation();
        $p1 = new Photo();
        $p2 = new Photo();
        $owner = new Owner();
        $um = new UserModel();
        $arrayPhoto = [];

        $owner->setName("Norman");
        $owner->setEmail("owner@email.com");
        $owner->setSurname("Coloma");
        $owner->setPhone("123456");
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

        $accom1 = $am->createAccom($a1, $um->getID($owner->getEmail()));

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
        $a1->setTitle('Alojamiento de lujo');

        $accom2 = $am->createAccom($a1, $um->getID($owner->getEmail()));

        $this->visit('/login')
            ->type('owner@email.com', 'email')->type('prueba','password')
            ->press('btn-login')
            ->seePageIs('/manage/owner')->see("Alojamientos")->see("Casa rural")->see("Alojamiento de lujo");
        $this->click("Eliminar")->dontSee("Alojamiento de lujo")->dontSee("Casa rural");
    }


}
