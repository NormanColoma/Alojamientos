<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Task; 
use DB;

class ApiTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     * @group apiTest
     */
    public function testDelete(){
        $response = $this->call('Delete', 'api/task/75');
        $this->assertNotTrue(null,$response);
        $this->assertEquals(404, $response->status());
        
    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group apiTest
     */
    public function testInsert(){
         $response = $this->call('POST', '/api/task', ['name' => 'Joan']);
         $this->assertNotTrue(null,$response);
         $this->assertEquals(200, $response->status());
    }

    public function tearDown(){
        DB::table('tasks')->where('name','Joan')->delete();  //Borramos lo que hemos insertado;
    }
}