<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 16/08/2015
 * Time: 11:54
 */

use App\Models\DTO\Admin;
use App\Models\DTO\Owner;
use App\Models\DTO\Traveler;
use App\Models\UserModel;

class UserAceptanceTest extends TestCase
{

    /*
    * Insertamos en la base de datos los ususario
    * que vamos a utilizar en las pruebas
    */
    public function setUp(){

        $userModel = new UserModel();
        $admin = new Admin();
        $traveler = new Traveler();
        $owner = new Owner();

        $admin->setName('Admin');
        $admin->setEmail('admin@email.com');
        $admin->setPassword("123456");

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
     * @group logPage
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
     * @group logPage
     * @test
     */
    public function try_login_with_existing_user(){
        $this->visit('/login')
            ->type('traveler@gmail.com', 'email')->type('123456','password')
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
     * @group logPage
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
     * @group logPage
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
     * @group logPage
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
     * @group logPage
     * @test
     */
    public function try_visit_login_page_once_authenticated(){
        $this->visit('/login')
            ->type('traveler@gmail.com', 'email')->type('123456','password')
            ->press('btn-login')
            ->seePageIs('/')->visit('login')->seePageIs('/home');
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

    public function tearDown(){
        DB::table('users')->where('email','traveler@email.com')->delete();  //Borramos lo que hemos insertado;
        DB::table('users')->where('email','owner@email.com')->delete();
        DB::table('users')->where('email','admin@email.com')->delete();
    }

}
