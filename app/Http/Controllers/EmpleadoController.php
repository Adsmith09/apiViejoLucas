<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleado=Cache::remember('cacheempleado',20/60, function()
        {
            return Empleado::all();
        });

        return response()->json(['status'=>'ok','data'=>$empleado], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->nombres || !$request->apellidos || !$request->dni || !$request->correo|| $request->telefono || $request->idUbicacion == -1 || $request->idUbicacion == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoEmpleado=Empleado::create($request->all());

        return response()->json(['data'=>$nuevoEmpleado], 201)->header('Location', url('/api/v1/').'/empleado/'.$nuevoEmpleado->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empleado=Empleado::find($id);

		if (!$empleado)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún emplea$empleado$empleado con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$empleado], 200);
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
        $empleado=Empleado::find($id);

		if (!$empleado)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún clei$empleado con este código.'])], 404);
		}

		$nombres=$request->nombres;
		$apellidos=$request->apellidos;
        $dni=$request->dni;
        $correo=$request->correo;
        $telefono=$request->telefono;
        $vigencia=$request->vigencia;
        $idUbicacion=$request->idUbicacion;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$empleado->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$empleado->save();
				return response()->json(['status'=>'ok','data'=>$empleado], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del clei$empleado.'])], 304);
			}
		}

		if (!$request->nombres || !$request->apellidos || !$request->dni || !$request->correo|| $request->telefono || $request->idUbicacion == -1 || $request->idUbicacion == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$empleado->nombre=$nombres;
        $empleado->descripcion=$apellidos;
        $empleado->categoria=$dni;
        $empleado->precio=$correo;
        $empleado->imagen=$telefono;
		$empleado->vigencia=$vigencia;
        $empleado->idUbicacion=$idUbicacion;

		$empleado->save();
		return response()->json(['status'=>'ok','data'=>$empleado], 200);
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
