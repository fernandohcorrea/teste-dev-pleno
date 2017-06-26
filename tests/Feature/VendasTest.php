<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VendasTest extends TestCase
{
    private $uriEndPoint;
    private $uriEndPointVendedores;
    private $vendedor;
    
    protected function setUp()
    {
        $this->uriEndPoint = '/api/vendas';
        $this->uriEndPointVendedores = '/api/vendedores';
        
        $testCase = parent::setUp();
        
        $data = [
            'nome'  => 'Fernando H Correa',
            'email' => 'fernandohcorrea@gmail.com'
        ];
        
        $response = $this->post($this->uriEndPointVendedores, $data);
        $this->vendedor = $response->decodeResponseJson();
        $response = $this->get($this->uriEndPointVendedores . "/{$this->vendedor['id']}");
        $this->vendedor = $response->decodeResponseJson();
        
        return $testCase;
    }

    protected function tearDown()
    {
        $this->delete($this->uriEndPointVendedores ."/{$this->vendedor['id']}");
        return parent::tearDown();
    }   

    public function testVendasTest()
    {
        $data = [
            'id_vendedor' => $this->vendedor['id'],
            'valor_venda' => 100
        ];
        
        $response = $this->post($this->uriEndPoint, $data);
        $response->assertStatus(201);
        
        $venda = $response->decodeResponseJson();
        
        $this->assertEquals(8.50, $venda['valor_comissao']);        
        
        //Delete
        $responseDelete = $this->delete($this->uriEndPoint. "/{$venda['id']}");
        $responseDelete->assertStatus(200);
    }
    
    public function testVendedorVendasTest()
    {
        $count = 3;
        $data_vendas = [];
        
        for ($i = 0; $i < $count; $i++ ){
            $data  = [
                'id_vendedor' => $this->vendedor['id'],
                'valor_venda' => rand(1, 100)
            ];
            
            $venda_asset = ($data['valor_venda'] / 100 ) * $this->vendedor['comissao'];
            
            $responsePost = $this->post($this->uriEndPoint, $data);
            $responsePost->assertStatus(201);
            $venda = $responsePost->decodeResponseJson();
            
            $venda['venda_asset'] = $venda_asset;
            
            $data_vendas[$venda['id']] = $venda;
        }
        
        
        $responseGet =  $this->get($this->uriEndPointVendedores . "/{$this->vendedor['id']}/vendas");
        $vendas = $responseGet->decodeResponseJson();
        
        $this->assertEquals($count, count($vendas['vendas']));        
        
        //Delete
        foreach ($data_vendas as $id_venda => $data) {
            $responseDelete = $this->delete($this->uriEndPoint. "/{$id_venda}");
            $responseDelete->assertStatus(200);
        }
    }
    
}
