<?php

namespace App\Http\Controllers;

use App\Models\DetalleProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DetalleProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detalleProducto=Cache::remember('cachedetalleProducto',20/60, function()
        {
            return DetalleProducto::all();
        });

        return response()->json(['status'=>'ok','data'=>$detalleProducto], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->idProducto == -1 || $request->idProducto == 0 )
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoDetalleProducto=DetalleProducto::create($request->all());

        return response()->json(['data'=>$nuevoDetalleProducto], 201)->header('Location', url('/api/v1/').'/detalleProducto/'.$nuevoDetalleProducto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detalleProducto=DetalleProducto::find($id);

		if (!$detalleProducto)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún detalleProducto con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$detalleProducto], 200);
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
        $detalleProducto=DetalleProducto::find($id);

		if (!$detalleProducto)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún detalleProducto con este código.'])], 404);
		}

		$carne=$request->carne;
		$queso=$request->queso;
        $huevo=$request->huevo;
        $platanoFrito=$request->platanoFrito;
        $jamon=$request->jamon;
        $piña=$request->piña;
        $tocino=$$request->tocino;
        $salcHuachana=$$request->salcHuachana;
        $lechuga=$request->lechuga;
        $tomate=$request->tomate;
        $vigencia=$request->vigencia;
		$idProducto=$request->idProducto;
        $idAdicional=$request->idAdicional;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$detalleProducto->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$detalleProducto->save();
				return response()->json(['status'=>'ok','data'=>$detalleProducto], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del detalleProducto.'])], 304);
			}
		}

		if ($request->idProducto == -1 || $request->idProducto == 0 )
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$detalleProducto->nombre=$carne;
        $detalleProducto->queso=$queso;
        $detalleProducto->huevo=$huevo;
        $detalleProducto->platanoFrito=$platanoFrito;
        $detalleProducto->jamon=$jamon;
        $detalleProducto->piña=$piña;
        $detalleProducto->tocino=$tocino;
        $detalleProducto->salcHuachana=$salcHuachana;
        $detalleProducto->lechuga=$lechuga;
        $detalleProducto->tomate=$tomate;
		$detalleProducto->vigencia=$vigencia;
		$detalleProducto->idMProducto=$idProducto;
        $detalleProducto->idAdicional=$idAdicional;

		$detalleProducto->save();
		return response()->json(['status'=>'ok','data'=>$detalleProducto], 200);
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
