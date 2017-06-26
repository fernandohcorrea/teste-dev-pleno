<?php

namespace App\Http\Controllers;

use App\Vendedor;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VendedoresController extends Controller
{
    public function index()
    {
        $vendedores = Vendedor::all();
        return response()->json($vendedores);
    }
    
    public function show($id)
    {
        $vendedor = Vendedor::find($id);

        if(!$vendedor) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        return response()->json($vendedor);
    }
    
    public function store(Request $request)
    {
        $vendedor = new Vendedor();
        $vendedor->fill($request->all());
        
        try {
            $vendedor->save();
        } catch (\Exception $exc) {
            Log::error($exc->getMessage());
            return response()->json(['message' => 'Insert Fail'], 500);
        }
        
        return response()->json($vendedor, 201);
    }
    
    public function update(Request $request, $id)
    {
        $vendedor = Vendedor::find($id);

        if(!$vendedor) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $vendedor->fill($request->all());
        
        try{
            $vendedor->save();
        } catch (\Exception $exc) {
            Log::error($exc->getMessage());
            return response()->json(['message' => 'Update Fail'], 500);
        }

        return response()->json($vendedor);
    }
    
    public function destroy($id)
    {
        $vendedor = Vendedor::find($id);

        if(!$vendedor) {
            return response()->json([
                'message'   => 'Record not found',
            ], 404);
        }

        $vendedor->delete();
    }
}
