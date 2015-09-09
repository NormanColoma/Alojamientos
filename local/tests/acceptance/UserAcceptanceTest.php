<?php



use App\Models\DTO\Admin;
use App\Models\DTO\Owner;
use App\Models\DTO\Traveler;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserAcceptanceTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Test para visitar la página login.
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function see_login_page(){
        $this->visit('/login')->seePageIs('/login');
    }

    /**
     * Escenario: Login correcto de Viajero
     * Dado que soy un usuario del tipo Viajero y estoy en la página de 'Login'
     * Cuando relleno el formulario con los datos <E-mail> y <Contraseña>
     * Y hago click en el botón 'Login'
     * Entonces debo obtener el panel de control de un usuario del tipo Viajero
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_login_with_existing_user(){
        $userModel = new UserModel();
        $traveler = new Traveler();
        $traveler->setEmail('traveler@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('Traveler');
        $traveler->setOwner(false);
        $traveler->setPhone('654321987');
        $traveler->setSurname('Apellido2');
        $userModel->createUser($traveler);
        $this->visit('/login')
            ->type('traveler@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('/manage/traveler');
    }

    /**
     * Escenario: Login correcto de Propietario
     * Dado que soy un usuario del tipo Propietario y estoy en la página de 'Login'
     * Cuando relleno el formulario con los datos <E-mail> y <Contraseña>
     * Y hago click en el botón 'Login'
     * Entonces debo obtener el panel de control de un usuario del tipo Propietario
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_login_with_existing_user2(){
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
            ->seePageIs('/manage/owner');
    }

    /**
     * Escenario: Login correcto de Administrador
     * Dado que soy un usuario del tipo Administrador y estoy en la página de 'Login'
     * Cuando relleno el formulario con los datos <E-mail> y <Contraseña>
     * Y hago click en el botón 'Login'
     * Entonces debo obtener el panel de control de un usuario del tipo Administrador
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_login_with_existing_user3(){
        $userModel = new UserModel();
        $admin = new Admin();

        $admin->setName('Admin');
        $admin->setEmail('admin@email.com');
        $admin->setPassword("123456");
        $admin->setAdmin(true);
        $admin->setOwner(false);

        $userModel->createUser($admin);
        $this->visit('/login')
            ->type('admin@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('/manage/admin');
    }

    /**
     * Escenario: Login incorrecto
     * Dado que estoy en la página de 'Login'
     * Cuando relleno el formulario con los datos <E-mail> y <Contraseña>
     * Y estos datos son incorrectos O el usuario no se encuentra registrado en el sistema
     * Cuando pulso el botón 'Login'
     * Entonces debo mostrar el siguiente mensaje 'El E-mail y/o la Contraseña no son válidos'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_login_with_non_existing_user(){
        $this->visit('/login')
            ->type('traveler@gmail.com', 'email')->type('capul','password')
            ->press('btn-login')
            ->see('El usuario o la contraseña no son correctos');
    }

    /**
     * Escenario: Login ya realizado
     * Dado que soy un usuario del sistema y ya estoy logueado
     * Cuando intento acceder de nuevo a la página del login
     * Entonces debo ser redireccionado a la página Home
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_visit_login_page_once_authenticated(){
        $userModel = new UserModel();
        $traveler = new Traveler();

        $traveler->setEmail('traveler@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('Traveler');
        $traveler->setOwner(false);
        $traveler->setPhone('654321987');
        $traveler->setSurname('Apellido2');

        $userModel->createUser($traveler);

        $this->visit('/login')
            ->type('traveler@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('/manage/traveler')->visit('login')->seePageIs('/home');
    }


    /**
     * Escenario: Registro con campo email vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo email vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El email es obligatorio'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_valid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('Comino', 'surname')
            ->type('prueba1','password')->type('654987321', 'phone')
            ->press('btn-register')
            ->seePageIs('/manage/traveler');
    }

    /**
     * Escenario: Registro con campo email vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo email vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El email es obligatorio'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_email_empty(){
        $this->visit('/register')
            ->type('Javi', 'name')->type('Comino', 'surname')->type('prueba1','password')->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El email es obligatorio');
    }

    /**
     * Escenario: Registro con campo nombre vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo nombre vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El nombre es obligatorio'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_name_empty(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Comino', 'surname')->type('prueba1','password')->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El nombre es obligatorio');
    }

    /**
     * Escenario: Registro con campo apellido vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo apellido vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'Los apellidos son obligatorios'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_surname_empty(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('prueba1','password')->type('654987321', 'phone')
            ->press('btn-register')
            ->see('Los apellidos son obligatorios');
    }

    /**
     * Escenario: Registro con campo contraseña vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo contraseña vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'La contraseña es obligatoria'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_password_empty(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('Comino','surname')->type('654987321', 'phone')
            ->press('btn-register')
            ->see('La contraseña es obligatoria');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo teléfono vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo teléfono vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El teléfono es obligatorio'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_phone_empty(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->press('btn-register')
            ->see('El teléfono es obligatorio');
    }

    /**
     * Escenario: Registro con campo email incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo un email incorrecto
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El email introducido no es correcto'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_email_notValid(){
        $this->visit('/register')
            ->type('registro', 'email')->type('Javi', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El email introducido no es correcto');
    }

    /**
     * Escenario: Registro con campo contraseña incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo una contraseña incorrecta
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_password_notValid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('Comino','surname')->type('123456', 'password')
            ->type('654987321', 'phone')
            ->press('btn-register')
            ->see('La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo nombre incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo un nombre incorrecto
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El nombre solo puede contener letras'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_name_notValid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('123456', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El nombre solo puede contener letras');
    }

    /**
     * Escenario: Registro con campo apellido incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo un apellido incorrecto
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'Los apellidos solo puede contener letras'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_surname_notValid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('123456','surname')->type('prueba1', 'password')
            ->type('654987321', 'phone')
            ->press('btn-register')
            ->see('Los apellidos solo puede contener letras');
    }

    /**
     * Escenario: Registro con campo teléfono incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo un teléfono incorrecto
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El teléfono solo puede contener números, y debe ser correcto'
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function try_register_phone_notValid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->type('prueba', 'phone')
            ->press('btn-register')
            ->see('El teléfono solo puede contener números, y debe ser correcto');//seePageIs('/login');
    }

    /**
     * Escenario: Actualizar cuenta Owner con campos vacíos
     * Dado que estoy en la página de 'Mi cuenta' siendo un Owner
     * Si dejo los campos vacíos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces debo mostrar los mensajes de que "Los campos son obligatorios"
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_owner_account_empty(){

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

        $this->visit("/manage/owner#account")->press("Actulizar cuenta")
        ->see("El nombre es obligatorio")->see("Los apellidos son obligatorios")
        ->see("El email es obligatorio")->see("La contraseña es obligatoria")
        ->see("El teléfono es obligatorio");

    }

    /**
     * Escenario: Actualizar cuenta Admin con campos vacíos
     * Dado que estoy en la página de 'Mi cuenta' siendo un Admin
     * Si dejo los campos vacíos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces debo mostrar los mensajes de que "Los campos son obligatorios"
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_admin_account_empty(){

        $um = new UserModel();
        $admin = new Admin();

        $admin->setName("Norman");
        $admin->setEmail("norman@email.com");
        $admin->setSurname("Coloma");
        $admin->setPhone("654987321");
        $admin->setPassword("123456");

        $um->createUser($admin);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/admin');

        $this->visit("/manage/admin#account")->press("Actulizar cuenta")
            ->see("El nombre es obligatorio")->see("Los apellidos son obligatorios")
            ->see("El email es obligatorio")->see("La contraseña es obligatoria")
            ->see("El teléfono es obligatorio");
    }

    /**
     * Escenario: Actualizar cuenta Traveler con campos vacíos
     * Dado que estoy en la página de 'Mi cuenta' siendo un Traveler
     * Si dejo los campos vacíos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces debo mostrar los mensajes de que "Los campos son obligatorios"
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_traveler_account_empty(){

        $um = new UserModel();
        $traveler = new Traveler();

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("123456");

        $um->createUser($traveler);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/traveler');

        $this->visit("/manage/traveler#account")->press("Actulizar cuenta")
            ->see("El nombre es obligatorio")->see("Los apellidos son obligatorios")
            ->see("El email es obligatorio")->see("La contraseña es obligatoria")
            ->see("El teléfono es obligatorio");
    }

    /**
     * Escenario: Actualizar cuenta Owner
     * Dado que estoy en la página de 'Mi cuenta' siendo un Owner
     * Si completo correctamente los campos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces los datos de la cuenta deben actualizarse correctamente
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_owner_account(){

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

        $this->visit("/manage/owner#account")->type("Jose", "name")->type("Perez", "surname")->type("pepe@email.com","email")
            ->type("prueba", "password")->type("654789345", "phone")->press("Actulizar cuenta")
            ->dontSee("El nombre es obligatorio")->dontSee("Los apellidos son obligatorios")
            ->dontSee("El email es obligatorio")->dontSee("La contraseña es obligatoria")
            ->dontSee("El teléfono es obligatorio");

    }

    /**
     * Escenario: Actualizar cuenta Admin
     * Dado que estoy en la página de 'Mi cuenta' siendo un Admin
     * Si completo correctamente los campos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces los datos de la cuenta deben actualizarse correctamente
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_admin_account(){

        $um = new UserModel();
        $admin = new Admin();

        $admin->setName("Norman");
        $admin->setEmail("norman@email.com");
        $admin->setSurname("Coloma");
        $admin->setPhone("654987321");
        $admin->setPassword("123456");

        $um->createUser($admin);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/admin');

        $this->visit("/manage/admin#account")->type("Jose", "name")->type("Perez", "surname")->type("pepe@email.com","email")
            ->type("prueba", "password")->type("654789345", "phone")->press("Actulizar cuenta")
            ->dontSee("El nombre es obligatorio")->dontSee("Los apellidos son obligatorios")
            ->dontSee("El email es obligatorio")->dontSee("La contraseña es obligatoria")
            ->dontSee("El teléfono es obligatorio");
    }

    /**
     * Escenario: Actualizar cuenta Traveler
     * Dado que estoy en la página de 'Mi cuenta' siendo un Traveler
     * Si completo correctamente los campos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces los datos de la cuenta deben actualizarse correctamente
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_traveler_account(){

        $um = new UserModel();
        $traveler = new Traveler();

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("123456");

        $um->createUser($traveler);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/traveler');

        $this->visit("/manage/traveler#account")->type("Jose", "name")->type("Perez", "surname")->type("pepe@email.com","email")
            ->type("prueba", "password")->type("654789345", "phone")->press("Actulizar cuenta")
            ->dontSee("El nombre es obligatorio")->dontSee("Los apellidos son obligatorios")
            ->dontSee("El email es obligatorio")->dontSee("La contraseña es obligatoria")
            ->dontSee("El teléfono es obligatorio");
    }

    /**
     * Escenario: Actualizar cuenta Owner con campos incorrectos
     * Dado que estoy en la página de 'Mi cuenta' siendo un Owner
     * Si completo los campos pero son incorrectos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces debo mostrar los mensajes de error indicando que los datos introducidos no son correctos
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_owner_account_invalid(){

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

        $this->visit("/manage/owner#account")->type("1", "name")->type("1", "surname")->type("pepe","email")
            ->type("123", "password")->type("asd", "phone")->press("Actulizar cuenta")
            ->see("El nombre solo puede contener letras")->see("Los apellidos solo puede contener letras")
            ->see("El email introducido no es correcto")->see("La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica")
            ->see("El teléfono solo puede contener números, y debe ser correcto");

    }

    /**
     * Escenario: Actualizar cuenta Admin con campos incorrectos
     * Dado que estoy en la página de 'Mi cuenta' siendo un Admin
     * Si completo los campos pero son incorrectos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces debo mostrar los mensajes de error indicando que los datos introducidos no son correctos
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_admin_account_invalid(){

        $um = new UserModel();
        $admin = new Admin();

        $admin->setName("Norman");
        $admin->setEmail("norman@email.com");
        $admin->setSurname("Coloma");
        $admin->setPhone("654987321");
        $admin->setPassword("123456");

        $um->createUser($admin);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/admin');

        $this->visit("/manage/admin#account")->type("1", "name")->type("1", "surname")->type("pepe","email")
            ->type("123", "password")->type("asd", "phone")->press("Actulizar cuenta")
            ->see("El nombre solo puede contener letras")->see("Los apellidos solo puede contener letras")
            ->see("El email introducido no es correcto")->see("La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica")
            ->see("El teléfono solo puede contener números, y debe ser correcto");
    }

    /**
     * Escenario: Actualizar cuenta Traveler con campos incorrectos
     * Dado que estoy en la página de 'Mi cuenta' siendo un Traveler
     * Si completo los campos pero son incorrectos
     * Cuando pulso el botón 'Actualizar cuenta'
     * Entonces debo mostrar los mensajes de error indicando que los datos introducidos no son correctos
     *
     * @return void
     * @group userAcceptance
     * @test
     */
    public function updating_traveler_account_invalid(){

        $um = new UserModel();
        $traveler = new Traveler();

        $traveler->setName("Norman");
        $traveler->setEmail("norman@email.com");
        $traveler->setSurname("Coloma");
        $traveler->setPhone("654987321");
        $traveler->setPassword("123456");

        $um->createUser($traveler);

        $this->visit('/login')
            ->type('norman@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('manage/traveler');

        $this->visit("/manage/traveler#account")->type("1", "name")->type("1", "surname")->type("pepe","email")
            ->type("123", "password")->type("asd", "phone")->press("Actulizar cuenta")
            ->see("El nombre solo puede contener letras")->see("Los apellidos solo puede contener letras")
            ->see("El email introducido no es correcto")->see("La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica")
            ->see("El teléfono solo puede contener números, y debe ser correcto");
    }


}
