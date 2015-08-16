<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Task; 
use DB;

class TaskIntegrationTest extends TestCase
{
	/**
     * A basic functional test example.
     *
     * @return void
     * @group integrationTest
     * El group lo usamos para solo ejecutar los test marcados con ese grupo empleando el comando "phpunit --group 	nombre_grupo" sin comillas. Usamos factorias para no tener que setear los datos del objeto y crearlo (normalment las factorias ponen los valores al azar, esto nos es útil a veces, pero cuando necesitamos conocer los datos, hacemos override como en este caso. Si quieres ver como se define una factoría, están en la carpeta "database/facrories") En este caso solo testeamos si las insercciones se hacen bien en la BD. Por eso solo comprobamos que hay 2 filas en la tabla, y que los usuarios Javi y Abi existen (ya que se han bindeado a los modelos). También podríamos haberlo hecho recorriendo la lista $tasks. Pero normalmente, si las insercciones se hacen bien, el modelo estará bien bindeado, por lo que es una manera fácil y rápida de comprobarlo. Aunque en ocasiones igual nos conviene más hacerlo de la otra forma o incluso haciendo consultas a la BD con el método find($id) y obteniendo los tasks que queremos respectivamente. 
     */
    public function testInsertTask(){  
        $task1 = factory(Task::class)->create([
        	 'name' => 'Javi',
        ]);

        $task2 = factory(Task::class)->create([
        	 'name' => 'Abi',
        ]);

        $tasks = Task::all();

        $this->assertEquals(2,count($tasks));
        $this->assertEquals("Javi",$task1->name);
        $this->assertEquals("Abi",$task2->name);
    }


}