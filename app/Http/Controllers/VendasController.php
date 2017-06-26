<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venda;
use App\Vendedor;

class VendasController extends Controller
{
    public function index()
    {
        $vendas = Vendas::all();
        return response()->json($vendas);
    }
    
    public function getVendasVendedor($idVendedor, $idVenda = null)
    {
        $vendedor = Vendedor::find($idVendedor);
        
        if(!$vendedor) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }
        
        $vendas = Venda::where('id_vendedores', $vendedor->id);
        
        if($idVenda > 0){
            $vendas->where('id', $idVenda);
        }
        
        $vendedor->vendas = $vendas->get();
        
        return response()->json($vendedor);
    }
    
    public function show($id)
    {
        $venda = Venda::find($id);

        if(!$venda) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($venda);
    }
    
    public function store(Request $request)
    {
        $id_vendedor = $request->get('id_vendedor', null);
        $valor_venda = $request->get('valor_venda', 0);
        
        $vendedor = Vendedor::find($id_vendedor);
        
        if(!$vendedor){
            return response()->json([
                'message'   => 'Record vendedor not found',
            ], 400);
        }
        
        if($valor_venda <= 0){
            return response()->json([
                'message'   => 'Value of sale can\'t be less than zero',
            ], 400);
        }
        
        

        try{
            $venda = new Venda();
            $venda->id_vendedores = $id_vendedor;
            $venda->valor_venda = $valor_venda;
            $venda->valor_comissao = ($valor_venda/100) * $vendedor->comissao;
            
            $venda->save();
        } catch (\Exception $exc) {
            Log::error($exc->getMessage());
            return response()->json(['message' => 'Insert Fail'], 500);
        }
        
        return response()->json($venda, 201);
    }
    
    public function destroy($id)
    {
        $venda = Venda::find($id);

        if(!$venda) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $venda->delete();
    }
}
