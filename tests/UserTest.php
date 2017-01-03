<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCorrectLogin()
    {
	    $credentials = [
	        'email'    => 'newstandinfo@gmail.com',
	        'password' => 'crossover'
	    ];
	    $response = $this->call('POST','/login', $credentials);
	    $this->assertRedirectedTo('/profile', ['name']);
	 	$this->assertSessionHas(['name', 'id']);
	       
	}

	public function testEmptyCredentialsLogin()
    {
		$empty_credentials = [
	        'email'    => '',
	        'password' => ''
	    ];
	    $response = $this->call('POST','/login', $empty_credentials);
	}

}