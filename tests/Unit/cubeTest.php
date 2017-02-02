<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class cubeTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testPageCube()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    /**
     * A basic test example.
     */
	public function testCreateCube()
	    {
	        $response =  $this->call('POST', '/', ['text-in' =>'2
4 5
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
UPDATE 1 1 1 23
QUERY 2 2 2 4 4 4
QUERY 1 1 1 3 3 3
2 4
UPDATE 2 2 2 1
QUERY 1 1 1 1 1 1
QUERY 1 1 1 2 2 2
QUERY 2 2 2 2 2 2 ']);
	        $response
	        ->assertStatus(200);
	    }

	public function testCreateCubeBad()
	    {
	        $response =  $this->call('POST', '/', ['text-in' =>'2
4 5222
UPDATE 2 2 2 4
']);
	        $response
	        ->assertStatus(302);
	    }

}
