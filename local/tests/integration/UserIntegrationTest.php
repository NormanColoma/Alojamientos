<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 15/08/2015
 * Time: 20:13
 */

use App\Models\DTO\Traveler;
use App\Models\DTO\Admin;
use App\Models\DTO\Owner;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserIntegrationTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Insertamos un usuario en la base de datos
     *
     * @return void
     * @group insert
     */
    public function testInsertUser(){

        $this->notSeeInDatabase('users', ['email' => 'javier@email.com']);

        $userModel = new UserModel();
        $traveler = new Traveler();

        $traveler->setEmail('javier@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('Javier');
        $traveler->setOwner(false);
        $traveler->setPhone('654321987');
        $traveler->setSurname('Comino');

        $userModel->createUser($traveler);

        $this->seeInDatabase('users', ['email' => 'javier@email.com']);

        $traveler2 = new Traveler();

        $traveler2->setEmail('javier@email.com');
        $traveler2->setAdmin(false);
        $traveler2->setPassword('123456');
        $traveler2->setName('Javi Missed');
        $traveler2->setOwner(false);
        $traveler2->setPhone('654321987');
        $traveler2->setSurname('Vera');

        $userModel->createUser($traveler2);

        $this->notSeeInDatabase('users', ['name' => 'Javi Missed']);

    }

    /**
     * Actualizamos un usuario en la base de datos
     *
     * @return void
     * @group updateUser
     */
    public function testUpdateUser(){

        //$this->notSeeInDatabase('users', ['email' => 'javier@email.com']);

        $userModel = new UserModel();
        $traveler = new Traveler();

        $traveler->setEmail('prueba@email.com');
        $traveler->setAdmin(false);
        $traveler->setPassword('123456');
        $traveler->setName('NombrePrueba');
        $traveler->setOwner(false);
        $traveler->setPhone('156879654');
        $traveler->setSurname('ApellidoPrueba');

        $user = $userModel->createUser($traveler);

        $this->seeInDatabase('users', ['email' => 'prueba@email.com']);

        $traveler2 = new Traveler();

        $traveler2->setEmail('missed@email.com');
        $traveler2->setAdmin(false);
        $traveler2->setPassword('123456');
        $traveler2->setName('Javi Missed');
        $traveler2->setOwner(false);
        $traveler2->setPhone('654321987');
        $traveler2->setSurname('Vera');

        $this->assertTrue($userModel->updateUser($user['id'], $traveler2));

        $this->SeeInDatabase('users', ['name' => 'Javi Missed']);

    }

}
