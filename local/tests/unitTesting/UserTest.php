<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 12/08/2015
 * Time: 18:08
 */

use App\Models\DTO\AbstractUser;
use App\Models\DTO\Admin;
use App\Models\DTO\Owner;
use App\Models\DTO\Traveler;
use App\Models\UserModel;

class UserTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     * @group prueba
     */
    public function testAdmin(){
        $adm = new Admin();

        $adm->setName('Jose');
        $adm->setEmail('jose@email.com');
        $adm->setPassword("password");

        $this->assertEquals('Jose', $adm->getName());
        $this->assertEquals('password', $adm->getPassword());
        $this->assertEquals('jose@email.com', $adm->getEmail());

    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group prueba
     */
    public function testOwner(){
        $own = new Owner();

        $own->setEmail('owner@email.com');
        $own->setAdmin(false);
        $own->setPassword('123456');
        $own->setName('Owner');
        $own->setId(1);
        $own->setOwner(true);
        $own->setPhone('654321987');
        $own->setSurname('Apellido');

        $this->assertEquals('owner@email.com', $own->getEmail());
        $this->assertEquals(false, $own->getAdmin());
        $this->assertEquals('123456', $own->getPassword());
        $this->assertEquals('Owner', $own->getName());
        $this->assertEquals(1, $own->getId());
        $this->assertEquals(true, $own->getOwner());
        $this->assertEquals('654321987', $own->getPhone());
        $this->assertEquals('Apellido', $own->getSurname());
    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group prueba
     */
    public function testTraveler(){
        $trv = new Traveler();

        $trv->setEmail('traveler@email.com');
        $trv->setAdmin(false);
        $trv->setPassword('123456');
        $trv->setName('Traveler');
        $trv->setId(2);
        $trv->setOwner(false);
        $trv->setPhone('654321987');
        $trv->setSurname('Apellido2');

        $this->assertEquals('traveler@email.com', $trv->getEmail());
        $this->assertEquals(false, $trv->getAdmin());
        $this->assertEquals('123456', $trv->getPassword());
        $this->assertEquals('Traveler', $trv->getName());
        $this->assertEquals(2, $trv->getId());
        $this->assertEquals(false, $trv->getOwner());
        $this->assertEquals('654321987', $trv->getPhone());
        $this->assertEquals('Apellido2', $trv->getSurname());
    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group modelo
     */
    public function testCreate(){
        $userModel = new UserModel();
        $admin = new Admin();
        $traveler = new Traveler();
        $owner = new Owner();

        $admin->setName('Jose');
        $admin->setEmail('joe@email.com');
        $admin->setPassword("password");

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

        $ok= $userModel->createUser($admin);

        $this->assertEquals(true, $ok);
        //$this->assertEquals(true, $userModel->createUser($traveler));
        //$this->assertEquals(true, $userModel->createUser($owner));
    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group login
     * @test
     */
    public function login_with_existing_user(){
        $request =(['email'=>'ua.norman@gmail.com', 'password'=>'capulleitor']);
        $this->call('Post','login',$request);
        $this->assertRedirectedTo('/');

    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group login
     * @test
     */
    public function login_with_non_existing_user(){
        $request =(['email'=>'ua.norman@gmail.com', 'password'=>'pepe']);
        $this->call('Post','login',$request);
        $this->assertRedirectedTo('/login');

    }

}
