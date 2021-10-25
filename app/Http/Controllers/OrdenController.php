<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orden=Cache::remember('cacheorden',20/60, function()
        {
            return Orden::all();
        });

        return response()->json(['status'=>'ok','data'=>$orden], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->fecha || !$request->total || $request->idModoPago == -1 || $request->idModoPago == 0 || $request->idUsuario == -1 || $request->idUsuario == 0 || $request->idDetalleOrden == -1 || $request->idDetalleOrden == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevaOrden=Orden::create($request->all());

        return response()->json(['data'=>$nuevaOrden], 201)->header('Location', url('/api/v1/').'/orden/'.$nuevaOrden->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orden=Orden::find($id);

		if (!$orden)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún orden$orden con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$orden], 200);
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
        $orden=Orden::find($id);

		if (!$orden)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún orden$orden con este código.'])], 404);
		}

		$fecha=$request->fecha;
		$total=$request->total;
        $vigencia=$request->vigencia;
		$idModoPago=$request->idModoPago;
        $idUsuario=$request->idUsuario;
        $idDetalleOrden=$request->idDetalleOrden;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$orden->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$orden->save();
				return response()->json(['status'=>'ok','data'=>$orden], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del orden$orden.'])], 304);
			}
		}

		if (!$request->fecha || !$request->total || $request->idModoPago == -1 || $request->idModoPago == 0 || $request->idUsuario == -1 || $request->idUsuario == 0 || $request->idDetalleOrden == -1 || $request->idDetalleOrden == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$orden->fecha=$fecha;
        $orden->total=$total;
		$orden->vigencia=$vigencia;
		$orden->idModoPago=$idModoPago;
        $orden->idUsuario=$idUsuario;
        $orden->idDetalleOrden=$idDetalleOrden;

		$orden->save();
		return response()->json(['status'=>'ok','data'=>$orden], 200);
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
