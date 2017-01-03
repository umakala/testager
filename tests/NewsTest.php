<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomePageContainsNewsList()
    {
        $this->call('GET', '/');
    	$this->assertViewHas('list');
    }

    public function testDeleteNewsList()
    {
        $response = $this->call('GET', 'news/delete/100298');
    	$this->assertResponseStatus(302);
	}
	
}