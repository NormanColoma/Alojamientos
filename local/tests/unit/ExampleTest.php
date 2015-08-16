<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Task; 

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     * @group unitTesting
     */
    public function testBasicExample()
    {
        $test = 2;
        $this->assertEquals(2,$test);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     * @group unitTesting
     */
    public function testConcat(){
        $t1 = new Task;
        $t2 = new Task;
        $t1->name = "Norman trabaja con ";
        $t2->name = "Javi.";
        $t1->concat($t2);
        $this->assertEquals("Norman trabaja con Javi.",$t1->name);
    }
}
