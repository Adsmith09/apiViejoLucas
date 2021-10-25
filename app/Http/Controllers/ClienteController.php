<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cliente=Cache::remember('cachecliente',20/60, function()
        {
            return Cliente::all();
        });

        return response()->json(['status'=>'ok','data'=>$cliente], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->nombres || !$request->apellidos || !$request->correo )
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoCliente=Cliente::create($request->all());

        return response()->json(['data'=>$nuevoCliente], 201)->header('Location', url('/api/v1/').'/cliente/'.$nuevoCliente->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente=Cliente::find($id);

		if (!$cliente)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún cliente$cliente con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$cliente], 200);
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
        $cliente=Cliente::find($id);

		if (!$cliente)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún clei$cliente con este código.'])], 404);
		}

		$nombres=$request->nombres;
		$apellidos=$request->apellidos;
        $dni=$request->dni;
        $correo=$request->correo;
        $telefono=$request->telefono;
        $vigencia=$request->vigencia;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$cliente->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$cliente->save();
				return response()->json(['status'=>'ok','data'=>$cliente], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del clei$cliente.'])], 304);
			}
		}

		if (!$request->nombres || !$request->apellidos || !$request->correo )
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$cliente->nombres=$nombres;
        $cliente->apellidos=$apellidos;
        $cliente->dni=$dni;
        $cliente->correo=$correo;
        $cliente->telefono=$telefono;
		$cliente->vigencia=$vigencia;

		$cliente->save();
		return response()->json(['status'=>'ok','data'=>$cliente], 200);
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
