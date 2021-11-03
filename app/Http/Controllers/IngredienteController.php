<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ingrediente=Cache::remember('cacheingrediente',20/60, function()
        {
            return Ingrediente::all();
        });

        return response()->json(['status'=>'ok','data'=>$ingrediente], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->nombre || !$request->precio)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoIngrediente=Ingrediente::create($request->all());

        return response()->json(['data'=>$nuevoIngrediente], 201)->header('Location', url('/api/v1/').'/ingrediente/'.$nuevoIngrediente->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingrediente=Ingrediente::find($id);

		if (!$ingrediente)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún ingrediente con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$ingrediente], 200);
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
        $ingrediente=Ingrediente::find($id);

		if (!$ingrediente)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún ingrediente con este código.'])], 404);
		}

		$nombre=$request->nombre;
		$precio=$request->precio;
        $vigencia=$request->vigencia;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$ingrediente->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$ingrediente->save();
				return response()->json(['status'=>'ok','data'=>$ingrediente], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del ingrediente.'])], 304);
			}
		}

		if (!$request->nombre || !$request->precio)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$ingrediente->nombre=$nombre;
        $ingrediente->precio=$precio;
		$ingrediente->vigencia=$vigencia;

		$ingrediente->save();
		return response()->json(['status'=>'ok','data'=>$ingrediente], 200);
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
