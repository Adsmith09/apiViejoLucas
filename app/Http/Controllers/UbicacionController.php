<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ubicacion=Cache::remember('cacheubicacion',20/60, function()
        {
            return Ubicacion::all();
        });

        return response()->json(['status'=>'ok','data'=>$ubicacion], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ubicacion)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevaUbicacion=Ubicacion::create($request->all());

        return response()->json(['data'=>$nuevaUbicacion], 201)->header('Location', url('/api/v1/').'/ubicacion/'.$nuevaUbicacion->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ubicacion=Ubicacion::find($id);

		if (!$ubicacion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún ub$ubicacion con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$ubicacion], 200);
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
        $ubicacion=Ubicacion::find($id);

		if (!$ubicacion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún ubica$ubicacion con este código.'])], 404);
		}

		$ubicacion=$request->ubicacion;
        $vigencia=$request->vigencia;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$ubicacion->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$ubicacion->save();
				return response()->json(['status'=>'ok','data'=>$ubicacion], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del ubica$ubicacion.'])], 304);
			}
		}

		if (!$request->ubicacion)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$ubicacion->nombre=$ubicacion;
		$ubicacion->vigencia=$vigencia;

		$ubicacion->save();
		return response()->json(['status'=>'ok','data'=>$ubicacion], 200);
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
