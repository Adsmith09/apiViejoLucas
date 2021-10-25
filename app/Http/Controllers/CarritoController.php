<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CarritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carrito=Cache::remember('cachecarrito',20/60, function()
        {
            return Carrito::all();
        });

        return response()->json(['status'=>'ok','data'=>$carrito], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->cantidad || $request->idUsuario == -1 || $request->idUsuario == 0 || $request->idProducto == -1 || $request->idProducto == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoCarrito=Carrito::create($request->all());

        return response()->json(['data'=>$nuevoCarrito], 201)->header('Location', url('/api/v1/').'/carrito/'.$nuevoCarrito->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carrito=Carrito::find($id);

		if (!$carrito)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún carrito$carrito con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$carrito], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carrito=Carrito::find($id);

		if (!$carrito)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún carrito$carrito con este código.'])], 404);
		}

		$cantidad=$request->cantidad;
        $vigencia=$request->vigencia;
		$idUsuario=$request->idUsuario;
        $idProducto=$request->idProducto;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$carrito->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$carrito->save();
				return response()->json(['status'=>'ok','data'=>$carrito], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del carrito$carrito.'])], 304);
			}
		}

		if (!$request->cantidad || $request->idUsuario == -1 || $request->idUsuario == 0 || $request->idProducto == -1 || $request->idProducto == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$carrito->cantidad=$cantidad;
		$carrito->vigencia=$vigencia;
		$carrito->idUsuario=$idUsuario;
        $carrito->idProducto=$idProducto;

		$carrito->save();
		return response()->json(['status'=>'ok','data'=>$carrito], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
