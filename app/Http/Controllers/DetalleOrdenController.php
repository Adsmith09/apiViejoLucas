<?php

namespace App\Http\Controllers;

use App\Models\DetalleOrden;
use App\Models\DetalleProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DetalleOrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detalleOrden=Cache::remember('cacheproducto',20/60, function()
        {
            return DetalleProducto::all();
        });

        return response()->json(['status'=>'ok','data'=>$detalleOrden], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->cantidad || !$request->precio || $request->idDetalleProducto == -1 || $request->idDetalleProducto == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoDetalleOrden=DetalleOrden::create($request->all());

        return response()->json(['data'=>$nuevoDetalleOrden], 201)->header('Location', url('/api/v1/').'/detalleOrden/'.$nuevoDetalleOrden->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalleOrden=DetalleOrden::find($id);

		if (!$detalleOrden)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún deta$detalleOrden con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$detalleOrden], 200);
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
        $detalleOrden=DetalleOrden::find($id);

		if (!$detalleOrden)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún detal$detalleOrden con este código.'])], 404);
		}

		$cantidad=$request->cantidad;
		$precio=$request->precio;
        $vigencia=$request->vigencia;
		$idDetalleProducto=$request->idDetalleProducto;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$detalleOrden->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$detalleOrden->save();
				return response()->json(['status'=>'ok','data'=>$detalleOrden], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del detal$detalleOrden.'])], 304);
			}
		}

		if (!$request->cantidad || !$request->precio || $request->idDetalleProducto == -1 || $request->idDetalleProducto == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$detalleOrden->cantidad=$cantidad;
        $detalleOrden->precio=$precio;
		$detalleOrden->vigencia=$vigencia;
		$detalleOrden->idDetalleProducto=$idDetalleProducto;

		$detalleOrden->save();
		return response()->json(['status'=>'ok','data'=>$detalleOrden], 200);
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
