<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario=Cache::remember('cacheusuario',20/60, function()
        {
            return Usuario::all();
        });

        return response()->json(['status'=>'ok','data'=>$usuario], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->usuario || !$request->contraseña || $request->idCliente == -1 || $request->idRol == -1 || $request->idRol == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoUsuario=Usuario::create($request->all());

        return response()->json(['data'=>$nuevoUsuario], 201)->header('Location', url('/api/v1/').'/usuario/'.$nuevoUsuario->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario=Usuario::find($id);

		if (!$usuario)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún usuar$usuario con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$usuario], 200);
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
        $usuario=Usuario::find($id);

		if (!$usuario)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún usu$usuario con este código.'])], 404);
		}

		$usuario=$request->usuario;
		$contraseña=$request->contraseña;
        $vigencia=$request->vigencia;
		$idCliente=$request->idCliente;
        $idEmpleado=$request->idEmpleado;
        $idRol=$request->idRol;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$usuario->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$usuario->save();
				return response()->json(['status'=>'ok','data'=>$usuario], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del usu$usuario.'])], 304);
			}
		}

		if (!$request->usuario || !$request->contraseña || $request->idCliente == -1 || $request->idRol == -1 || $request->idRol == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$usuario->usuario=$usuario;
        $usuario->contraseña=$contraseña;
		$usuario->vigencia=$vigencia;
		$usuario->idCliente=$idCliente;
        $usuario->idEmpleado=$idEmpleado;
        $usuario->idRol=$idRol;

		$usuario->save();
		return response()->json(['status'=>'ok','data'=>$usuario], 200);
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
