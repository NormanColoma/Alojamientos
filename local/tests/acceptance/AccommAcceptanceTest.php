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

use App\Models\DTO\Owner;
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
            ->type("Alicante","new-accom-city")->type("Alicante", "new-accom-province")->type("150","new-accom-price")
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
     * Escenario: Insertar un nuevo alojamiento campo provincia vacío
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y dejo vacío el provincia ciudad
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El campo es obligatorio"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_province_empty(){
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
            ->type("Alicante","new-accom-city")->type("", "new-accom-province")->type("150","new-accom-price")
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
     * Escenario: Insertar un nuevo alojamiento campo provincia no válido
     * Dado que soy un usuario del tipo Propietario y me he logueado correctamente
     * Cuando relleno el formulario para insertar un nuevo alojamiento
     * Y el campo provincia se rellena con números
     * Si hago click en el botón 'Anunciar'
     * Entonces debe aparecer un mensaje de "El formato introducido no es válido. Solo se permiten letras"
     *
     * @return void
     * @group accommAcceptance
     * @test
     */
    public function inserting_new_accommodation_province_invalid(){
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
            ->type("Alicante","new-accom-city")->type("1", "new-accom-province")->type("150","new-accom-price")
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
    /*public function inserting_new_accommodation_main_invalid(){
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
            ->type("Alicante","new-accom-city")->type("1", "new-accom-province")->type("150","new-accom-price")
            ->type("Esto es la descripción del anuncio","new-accom-desc")->attach(base_path() ."/resources/assets/img/img_test/falloFormato.txt","new-accom-main-img")->press("Anunciar")
            ->see("El archivo debe ser una imagen (jpeg, png, bmp, gif, or jpg)");
    }*/

}
