<?php

namespace App\Http\Controllers;

use App\Models\Adicional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdicionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adicional=Cache::remember('cacheadicional',20/60, function()
        {
            return Adicional::all();
        });

        return response()->json(['status'=>'ok','data'=>$adicional], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if ($request->aji || $request->mayonesa || $request->mostaza ) 
		// {         
		// 	return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        // }

        $nuevoAdicional=Adicional::create($request->all());

        return response()->json(['data'=>$nuevoAdicional], 201)->header('Location', url('/api/v1/').'/adicional/'.$nuevoAdicional->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adicional=Adicional::find($id);

		if (!$adicional)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún adi$adicional con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$adicional], 200);
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
        $adicional=Adicional::find($id);

		if (!$adicional)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún aid$adicional con este código.'])], 404);
		}

		$mermelada_tocino=$request->mermelada_tocino;
        $aji=$request->aji;
        $mayonesa=$request->mayonesa;
        $mostaza=$request->mostaza;
		$vigencia=$request->vigencia;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$adicional->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$adicional->save();
				return response()->json(['status'=>'ok','data'=>$adicional], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del aid$adicional.'])], 304);
			}
		}

		// if ($request->aji || $request->mayonesa || $request->mostaza )
		// {
		// 	return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		// }

		$adicional->mermelada_tocino=$mermelada_tocino;
        $adicional->aji=$aji;
        $adicional->mayonesa=$mayonesa;
        $adicional->mostaza=$mostaza;
		$adicional->vigencia=$vigencia;

		$adicional->save();
		return response()->json(['status'=>'ok','data'=>$adicional], 200);
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
