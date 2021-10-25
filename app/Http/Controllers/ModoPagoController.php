<?php

namespace App\Http\Controllers;

use App\Models\ModoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ModoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modoPago=Cache::remember('cachemodoPago',20/60, function()
        {
            return ModoPago::all();
        });

        return response()->json(['status'=>'ok','data'=>$modoPago], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->tipo || !$request->fraccionPago || !$request->montoEfectivo)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoModoPago=ModoPago::create($request->all());

        return response()->json(['data'=>$nuevoModoPago], 201)->header('Location', url('/api/v1/').'/modoPago/'.$nuevoModoPago->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modoPago=ModoPago::find($id);

		if (!$modoPago)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún modo$modoPago con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$modoPago], 200);
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
        $modoPago=ModoPago::find($id);

		if (!$modoPago)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún modo$modoPago con este código.'])], 404);
		}

		$tipo=$request->tipo;
		$fraccionPago=$request->fraccionPago;
        $montoEfectivo=$request->montoEfectivo;
        
		if (!$request->tipo || !$request->fraccionPago || !$request->montoEfectivo)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$modoPago->tipo=$tipo;
        $modoPago->fraccionPago=$fraccionPago;
        $modoPago->montoEfectivo=$montoEfectivo;

		$modoPago->save();
		return response()->json(['status'=>'ok','data'=>$modoPago], 200);
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
