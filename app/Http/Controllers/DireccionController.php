<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DireccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $direccion=Cache::remember('cachedireccion',20/60, function()
        {
            return Direccion::all();
        });

        return response()->json(['status'=>'ok','data'=>$direccion], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->calle || !$request->numero || !$request->referencia || !$request->ciudad || $request->idCliente == -1 || $request->idCliente == 0)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevaDireccion=Direccion::create($request->all());

        return response()->json(['data'=>$nuevaDireccion], 201)->header('Location', url('/api/v1/').'/direccion/'.$nuevaDireccion->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $direccion=Direccion::find($id);

		if (!$direccion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún direcc$direccion con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$direccion], 200);
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
        $direccion=Direccion::find($id);

		if (!$direccion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún dire$direccion con este código.'])], 404);
		}

		$calle=$request->calle;
		$numero=$request->numero;
        $referencia=$request->referencia;
        $ciudad=$request->ciudad;
        $vigencia=$request->vigencia;
		$idCliente=$request->idCliente;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$direccion->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$direccion->save();
				return response()->json(['status'=>'ok','data'=>$direccion], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del dire$direccion.'])], 304);
			}
		}

		if (!$request->calle || !$request->numero || !$request->referencia || !$request->ciudad || $request->idCliente == -1 || $request->idCliente == 0)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$direccion->nombre=$calle;
        $direccion->descripcion=$numero;
        $direccion->categoria=$referencia;
        $direccion->precio=$ciudad;
		$direccion->vigencia=$vigencia;
		$direccion->idCliente=$idCliente;

		$direccion->save();
		return response()->json(['status'=>'ok','data'=>$direccion], 200);
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
