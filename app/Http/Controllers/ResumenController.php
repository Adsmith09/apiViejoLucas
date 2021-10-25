<?php

namespace App\Http\Controllers;

use App\Models\Resumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ResumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resumen=Cache::remember('cacheresumen',20/60, function()
        {
            return Resumen::all();
        });

        return response()->json(['status'=>'ok','data'=>$resumen], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->pagoTotal || $request->idOrden == -1 || $request->idOrden == 0 || $request->idEnvio == -1 || $request->idEnvio == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoResumen=Resumen::create($request->all());

        return response()->json(['data'=>$nuevoResumen], 201)->header('Location', url('/api/v1/').'/resumen/'.$nuevoResumen->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resumen=Resumen::find($id);

		if (!$resumen)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún resumen con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$resumen], 200);
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
        $resumen=Resumen::find($id);

		if (!$resumen)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún resu$resumen con este código.'])], 404);
		}

		$pagoTotal=$request->pagoTotal;
        $vigencia=$request->vigencia;
		$idOrden=$request->idOrden;
        $idEnvio=$request->idEnvio;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$resumen->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$resumen->save();
				return response()->json(['status'=>'ok','data'=>$resumen], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del resu$resumen.'])], 304);
			}
		}

		if (!$request->pagoTotal || $idOrden == -1 || $idOrden == 0 || $idEnvio == -1 || $idEnvio == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$resumen->pagoTotal=$pagoTotal;
		$resumen->vigencia=$vigencia;
		$resumen->idOrden=$idOrden;
        $resumen->idEnvio=$idEnvio;

		$resumen->save();
		return response()->json(['status'=>'ok','data'=>$resumen], 200);
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
