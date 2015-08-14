<?php

/**
 * Created by IntelliJ IDEA.
 * User: Norman
 * Date: 14/08/2015
 * Time: 10:49
 */
class UserSystemTest extends TestCase
{
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
     * Visitamos la página login e intentamos loguearnos con un usario existente
     *
     * @return void
     * @group loginPage
     * @test
     */
    public function try_login_with_existing_user(){
        $this->visit('/login')
            ->type('ua.norman@gmail.com', 'email')->type('capulleitor','password')
            ->press('btn-login')
            ->seePageIs('/');
    }

    /**
     * Visitamos la página login e intentamos loguearnos con un usario no existente
     *
     * @return void
     * @group loginPage
     * @test
     */
    public function try_login_with_non_existing_user(){
        $this->visit('/login')
            ->type('ua.norman@gmail.com', 'email')->type('capul','password')
            ->press('btn-login')
            ->seePageIs('/login');
    }

    /**
     * Nos logueamos y después visitamos la página login otra vez. Deberemos ser redireccionados al home.
     *
     * @return void
     * @group loginPage
     * @test
     */
    public function try_visit_login_page_once_authenticated(){
        $this->visit('/login')
            ->type('ua.norman@gmail.com', 'email')->type('capulleitor','password')
            ->press('btn-login')
            ->seePageIs('/')->visit('login')->seePageIs('/home');
    }
}
