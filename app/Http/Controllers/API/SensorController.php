<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sensor;

class SensorController extends Controller
{
    private $sensor;    
    public function __construct(Sensor $sensor)
	{
		$this->sensor = $sensor;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['data' => $this->sensor::all()];
        return response() -> json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sensordata = $request->all();
        $this->sensor->create($sensordata);
        return response()->json(['msg'=> 'sensor criado com sucesso.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $id)
    {
        $data = ['data' => $id];
        return response() -> json($data);
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
        $sensordata = $request->all();
        $sensor = $this->sensor->find($id);
        $sensor->update($sensordata);
        return response()->json(['msg'=> 'sensor atualizado com sucesso.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id->delete();
        return response()-> json(['data'=> ['msg'=> 'sensor: '.$id->nome. ' deletado com sucesso.']],200);
    }
}
