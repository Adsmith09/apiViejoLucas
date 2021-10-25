<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rol=Cache::remember('cacherol',20/60, function()
        {
            return Rol::all();
        });

        return response()->json(['status'=>'ok','data'=>$rol], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->rol )
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoRol=Rol::create($request->all());

        return response()->json(['data'=>$nuevoRol], 201)->header('Location', url('/api/v1/').'/rol/'.$nuevoRol->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol=Rol::find($id);

		if (!$rol)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún rol con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$rol], 200);
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
        $rol=Rol::find($id);

		if (!$rol)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún rol$rol con este código.'])], 404);
		}

		$rol=$request->rol;
        $vigencia=$request->vigencia;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$rol->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$rol->save();
				return response()->json(['status'=>'ok','data'=>$rol], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del rol$rol.'])], 304);
			}
		}

		if (!$request->rol)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$rol->rol=$rol;
		$rol->vigencia=$vigencia;

		$rol->save();
		return response()->json(['status'=>'ok','data'=>$rol], 200);
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
