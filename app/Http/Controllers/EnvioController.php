<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $envio=Cache::remember('cacheenvio',20/60, function()
        {
            return Envio::all();
        });

        return response()->json(['status'=>'ok','data'=>$envio], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->costoEnvio || !$request->lugarEnvio || $request->idOrden == -1 || $request->idOrden == 0 || $request->idEmpleado == -1 || $request->idEmpleado == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoEnvio=Envio::create($request->all());

        return response()->json(['data'=>$nuevoEnvio], 201)->header('Location', url('/api/v1/').'/envio/'.$nuevoEnvio->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $envio=Envio::find($id);

		if (!$envio)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún envio$envio con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$envio], 200);
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
        $envio=Envio::find($id);

		if (!$envio)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún enivo$envio con este código.'])], 404);
		}

		$costoEnvio=$request->costoEnvio;
		$lugarEnvio=$request->lugarEnvio;
        $vigencia=$request->vigencia;
		$idOrden=$request->idOrden;
        $idEmpleado=$request->idEmpleado;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$envio->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$envio->save();
				return response()->json(['status'=>'ok','data'=>$envio], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del enivo$envio.'])], 304);
			}
		}

		if (!$request->costoEnvio || !$request->lugarEnvio || $request->idOrden == -1 || $request->idOrden == 0 || $request->idEmpleado == -1 || $request->idEmpleado == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$envio->nombre=$costoEnvio;
        $envio->descripcion=$lugarEnvio;
		$envio->vigencia=$vigencia;
		$envio->idOrden=$idOrden;
        $envio->idEmpleado=$idEmpleado;

		$envio->save();
		return response()->json(['status'=>'ok','data'=>$envio], 200);
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
