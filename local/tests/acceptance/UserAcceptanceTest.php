<?php

/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 14/08/2015
 * Time: 10:49
 */

use App\Models\DTO\Admin;
use App\Models\DTO\Owner;
use App\Models\DTO\Traveler;
use App\Models\UserModel;

class UserAcceptanceTest extends TestCase
{

    /**
     * Cargamos los usuarios que vamos a utilizar en las pruebas
     *
     * @return void
     * @group loginPage
     * @test
     */
    public function loadUsersTest(){
        /*$userModel = new UserModel();

        $traveler = factory(Traveler::class)->make([
            'email' => 'traveler@email.com',
            'password' => bcrypt('123456'),
        ]);
        $admin = factory(Admin::class)->make([
            'email' => 'admin@email.com',
            'password' => bcrypt('123456'),
        ]);
        $owner = factory(Owner::class)->make([
            'email' => 'owner@email.com',
            'password' => bcrypt('123456'),
        ]);*/

        $userModel = new UserModel();
        $admin = new Admin();
        $traveler = new Traveler();
        $owner = new Owner();


        $admin->setName('Admin');
        $admin->setEmail('admin@email.com');
        $admin->setPassword("123456");
        $admin->setAdmin(true);
        $admin->setOwner(false);

        $owner->setEmail('owner@email.com');
        $owner->setAdmin(false);
        $owner->setPassword('123456');
        $owner->setName('Owner');
        $owner->setOwner(true);
        $owner->setPhone('654321987');
        $owner->setSurname('Apellido');

        $traveler->setEmail('traveler@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('Traveler');
        $traveler->setOwner(false);
        $traveler->setPhone('654321987');
        $traveler->setSurname('Apellido2');

        $userModel->createUser($admin);
        $userModel->createUser($traveler);
        $userModel->createUser($owner);
    }

    /**
     * Test para visitar la página login.
     *
     * @return void
     * @group loginPage
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
     * @group loginPage
     * @test
     */
    public function try_login_with_existing_user(){
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
     * @group loginPage
     * @test
     */
    public function try_login_with_existing_user2(){
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
     * @group loginPage
     * @test
     */
    public function try_login_with_existing_user3(){
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
     * @group loginPage
     * @test
     */
    public function try_login_with_non_existing_user(){
        $this->visit('/login')
            ->type('traveler@gmail.com', 'email')->type('capul','password')
            ->press('btn-login')
            ->see('El usuario o la contraseña no son correctos');//seePageIs('/login');
    }

    /**
     * Escenario: Login ya realizado
     * Dado que soy un usuario del sistema y ya estoy logueado
     * Cuando intento acceder de nuevo a la página del login
     * Entonces debo ser redireccionado a la página Home
     *
     * @return void
     * @group loginPage
     * @test
     */
    public function try_visit_login_page_once_authenticated(){
        $this->visit('/login')
            ->type('traveler@email.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('/manage/traveler')->visit('login')->seePageIs('/home');
    }

    /**
     * Escenario: Login ya realizado
     * Dado que soy un usuario del sistema y ya estoy logueado
     * Cuando intento acceder de nuevo a la página del login
     * Entonces debo ser redireccionado a la página Home
     *
     * @return void
     * @group loginPage2
     * @test
     */
    /*public function try_logout(){
        $this->visit('/login')
            ->type('traveler@gmail.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('/manage/traveler')
            ->press('btn-logout');
    }*/

    /**
     * Escenario: Registro con campo email vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo email vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El email es obligatorio'
     *
     * @return void
     * @group registerPage
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
     * @group registerPage
     * @test
     */
    public function try_register_email_empty(){
        $this->visit('/register')
            ->type('Javi', 'name')->type('Comino', 'surname')->type('prueba1','password')->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El email es obligatorio');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo nombre vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo nombre vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El nombre es obligatorio'
     *
     * @return void
     * @group registerPage
     * @test
     */
    public function try_register_name_empty(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Comino', 'surname')->type('prueba1','password')->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El nombre es obligatorio');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo apellido vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo apellido vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'Los apellidos son obligatorios'
     *
     * @return void
     * @group registerPage
     * @test
     */
    public function try_register_surname_empty(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('prueba1','password')->type('654987321', 'phone')
            ->press('btn-register')
            ->see('Los apellidos son obligatorios');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo contraseña vacío
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y dejo el campo contraseña vacío
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'La contraseña es obligatoria'
     *
     * @return void
     * @group registerPage
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
     * @group registerPage
     * @test
     */
    public function try_register_phone_empty(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->press('btn-register')
            ->see('El teléfono es obligatorio');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo email incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo un email incorrecto
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El email introducido no es correcto'
     *
     * @return void
     * @group registerPage
     * @test
     */
    public function try_register_email_notValid(){
        $this->visit('/register')
            ->type('registro', 'email')->type('Javi', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El email introducido no es correcto');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo contraseña incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo una contraseña incorrecta
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'La contraseña introducida no es correcta. Debe tener un mínimo de 6 caractares, y un máximo de 15. Debe empezar por una letra, y solo puede ser alfanumérica'
     *
     * @return void
     * @group registerPage
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
     * @group registerPage
     * @test
     */
    public function try_register_name_notValid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('123456', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->type('654987321', 'phone')
            ->press('btn-register')
            ->see('El nombre solo puede contener letras');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo apellido incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo un apellido incorrecto
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'Los apellidos solo puede contener letras'
     *
     * @return void
     * @group registerPage
     * @test
     */
    public function try_register_surname_notValid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('123456','surname')->type('prueba1', 'password')
            ->type('654987321', 'phone')
            ->press('btn-register')
            ->see('Los apellidos solo puede contener letras');//seePageIs('/login');
    }

    /**
     * Escenario: Registro con campo teléfono incorrecto
     * Dado que estoy en la página de 'Registro'
     * Si completo los campos y escribo un teléfono incorrecto
     * Cuando pulso el botón 'Registrar'
     * Entonces debo mostrar el siguiente mensaje 'El teléfono solo puede contener números, y debe ser correcto'
     *
     * @return void
     * @group registerPage
     * @test
     */
    public function try_register_phone_notValid(){
        $this->visit('/register')
            ->type('registro@email.com', 'email')->type('Javi', 'name')->type('Comino','surname')->type('prueba1', 'password')
            ->type('prueba', 'phone')
            ->press('btn-register')
            ->see('El teléfono solo puede contener números, y debe ser correcto');//seePageIs('/login');
    }

    public function tearDown(){
        DB::table('users')->where('email','traveler@email.com')->delete();  //Borramos lo que hemos insertado;
        DB::table('users')->where('email','owner@email.com')->delete();
        DB::table('users')->where('email','admin@email.com')->delete();
        DB::table('users')->where('email','registro@email.com')->delete();
    }
}
