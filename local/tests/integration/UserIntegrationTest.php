<?php

/**
 * Created by IntelliJ IDEA.
 * User: Javier
 * Date: 15/08/2015
 * Time: 20:13
 */

use App\Models\DTO\Traveler;
use App\Models\UserModel;

class UserIntegrationTest extends TestCase
{

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

    }

}
