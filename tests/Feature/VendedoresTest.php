<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VendedoresTest extends TestCase
{
    private $uriEndPoint;
    
    protected function setUp()
    {
        $this->uriEndPoint = '/api/vendedores';
        return parent::setUp();
    }

    protected function tearDown()
    {
        return parent::tearDown();
    }   

    public function testCrudVendedoresTest()
    {
        $data = [
            'nome'  => 'Fernando H Correa',
            'email' => 'fernandohcorrea@gmail.com'
        ];
        
        //Create
        $responsePost = $this->post($this->uriEndPoint, $data);
        $responsePost->assertStatus(201);
        
        $vendedor = $responsePost->decodeResponseJson();
        $id_vendedor = $vendedor['id'];
        
        //Read
        $responseGet =  $this->get($this->uriEndPoint ."/{$id_vendedor}");
        $responseGet->assertStatus(200);
        
        $vendedor = $responseGet->decodeResponseJson();
        $vendedor['email'] = 'fernandohcorrea@fernandohcorrea.com.br';
        
        //Update
        $resposePut = $this->put($this->uriEndPoint ."/{$id_vendedor}", $vendedor);
        $resposePut->assertStatus(200);
        
        //Delete
        $resposeDelete = $this->delete($this->uriEndPoint ."/{$id_vendedor}");
        $resposeDelete->assertStatus(200);
        
    }
    
    public function testUniqueVendedoresTest()
    {
        $data = [
            'nome'  => 'Fernando H Correa',
            'email' => 'fernandohcorrea@gmail.com'
        ];
        
        
        $responsePost1 = $this->post($this->uriEndPoint, $data);
        $responsePost1->assertStatus(201);
        $vendedor = $responsePost1  ->decodeResponseJson();
        $id_vendedor = $vendedor['id'];
        
        $responsePost2 = $this->post($this->uriEndPoint, $data);
        $responsePost2->assertStatus(500);
        
        $resposeDelete = $this->delete($this->uriEndPoint ."/{$id_vendedor}");
    }
    
}
