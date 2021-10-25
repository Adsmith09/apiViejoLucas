<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producto=Cache::remember('cacheproducto',20/60, function()
        {
            return Producto::all();
        });

        return response()->json(['status'=>'ok','data'=>$producto], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->nombre || !$request->descripcion || !$request->categoria || !$request->precio || !$request->imagen)
		{         
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos para acceder a su solicitud.'])], 422);
        }

        $nuevoProducto=Producto::create($request->all());

        return response()->json(['data'=>$nuevoProducto], 201)->header('Location', url('/api/v1/').'/producto/'.$nuevoProducto->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto=Producto::find($id);

		if (!$producto)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún producto con este código.'])], 404);
		}

        return response()->json(['status'=>'ok','data'=>$producto], 200);
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
        $producto=Producto::find($id);

		if (!$producto)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encontró ningún producto con este código.'])], 404);
		}

		$nombre=$request->nombre;
		$descripcion=$request->descripcion;
        $categoria=$request->categoria;
        $precio=$request->precio;
        $imagen=$request->imagen;
        $vigencia=$request->vigencia;
		//$idDetalleProducto=$request->idDetalleProducto;

		if ($request->method()=='PATCH')
		{
			$bandera=false;

			if ($vigencia != null && $vigencia != '')
			{
				$producto->vigencia=$vigencia;
				$bandera=true;
			}

			if ($bandera)
			{
				$producto->save();
				return response()->json(['status'=>'ok','data'=>$producto], 200);
			}
			else
			{
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato del producto.'])], 304);
			}
		}

		if (!$request->nombre || !$request->descripcion || !$request->categoria || !$request->precio || !$request->imagen)
		{
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])], 422);
		}

		$producto->nombre=$nombre;
        $producto->descripcion=$descripcion;
        $producto->categoria=$categoria;
        $producto->precio=$precio;
        $producto->imagen=$imagen;
		$producto->vigencia=$vigencia;
		//$producto->idDetalleProducto=$idDetalleProducto;

		$producto->save();
		return response()->json(['status'=>'ok','data'=>$producto], 200);
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
